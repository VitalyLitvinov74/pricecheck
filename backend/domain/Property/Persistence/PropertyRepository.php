<?php

namespace app\domain\Property\Persistence;

use app\domain\Property\Persistence\snapshots\PropertiesSnapshot;
use app\domain\Property\Persistence\snapshots\PropertySnapshot;
use app\domain\Property\Properties;
use app\libs\LibsException;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\PropertiesRecord;
use app\records\PropertiesSettingsRecord;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\Query;

class PropertyRepository
{
    public function __construct(
        private ObjectMapper  $objectMapper = new ObjectMapper(),
        private UpsertBuilder $upsertBuilder = new UpsertBuilder()
    )
    {
    }

    /**
     * @param Properties $properties
     * @return void - id сохраненной записи
     * @throws LibsException
     * @throws Throwable
     * @throws Exception
     */
    public function upsert(Properties $properties): void
    {
        $data = $this->objectMapper->map($properties, PropertiesSnapshot::class);
        $insertData = [];
        foreach ($data->collection as $property) {
            $insertData[] = [
                'id' => $property->id,
                'type' => $property->type,
                'name' => $property->name
            ];
        }
        $trx = Yii::$app->db->beginTransaction();
        try {
            $this->upsertBuilder
                ->useActiveRecord(PropertiesRecord::class)
                ->useUniqueKeys(['id'])
                ->upsertManyRecords($insertData);
            $actualNames = [];
            foreach ($data->collection as $property) {
                if ($property->name) {
                    $actualNames[] = $property->name;
                }
            }
            PropertiesRecord::deleteAll(['not in', 'name', $actualNames]);
            $this->saveSettings($data->collection);
            $trx->commit();
        } catch (Throwable $throwable) {
            $trx->rollBack();
            throw  $throwable;
        }
    }

    /**
     * @param PropertySnapshot[] $propertiesSnapshots
     * @return void
     * @throws LibsException
     */
    private function saveSettings(array $propertiesSnapshots): void
    {
        $insertData = [];
        foreach ($propertiesSnapshots as $propertySnapshot) {
            foreach ($propertySnapshot->settingsSnapshots as $settingSnapshot) {
                $insertData[] = [
                    'property_id' => $settingSnapshot->propertyId,
                    'setting_type_id' => $settingSnapshot->type
                ];
            }
        }
        $this->upsertBuilder
            ->useActiveRecord(PropertiesSettingsRecord::class)
            ->useUniqueKeys(['property_id', 'setting_type_id'])
            ->upsertManyRecords($insertData);
    }

    public function findAll(): Properties
    {
        $list = PropertiesRecord::find()
            ->with(['settings' => function (Query $query) {
                $query->emulateExecution();
            }])
            ->asArray()
            ->all();
        $list = [
            "collection" => $list
        ];
        return $this->objectMapper->map($list, Properties::class);
    }
}