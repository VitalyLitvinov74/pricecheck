<?php

namespace app\domain\Property\Persistence;

use app\domain\Property\Persistence\snapshots\PropertySnapshot;
use app\domain\Property\Property;
use app\libs\LibsException;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\ProductAttributesRecord;
use app\records\PropertiesSettingsRecord;
use app\records\PropertyRecord;
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
     * @param Property[] $properties
     * @return void - id сохраненной записи
     * @throws LibsException
     * @throws Throwable
     * @throws Exception
     */
    public function saveAll(array $properties): void
    {
        $insertData = [];
        $snapshots = [];
        foreach ($properties as $property) {
            $snapshot = $this->objectMapper->map($property, PropertySnapshot::class);
            $snapshots[] = $snapshot;
            $insertData[] = [
                'id' => $snapshot->id,
                'type' => $snapshot->type,
                'name' => $snapshot->name
            ];
        }
        $trx = Yii::$app->db->beginTransaction();
        try {
            $this->upsertBuilder
                ->useActiveRecord(PropertyRecord::class)
                ->useUniqueKeys(['id'])
                ->upsertManyRecords($insertData);
            $actualNames = [];
            foreach ($snapshots as $snapshot) {
                if ($snapshot->name) {
                    $actualNames[] = $snapshot->name;
                }
            }
            $this->saveSettings($snapshots);
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

    public function exist(string $name, string $type): bool
    {
        return PropertyRecord::find()
            ->where([
                'name' => $name,
                'type' => $type
            ])
            ->exists();
    }

    /**
     * @return Property[]
     */
    public function findAll(array $ids = []): array
    {
        $list = PropertyRecord::find()
            ->andFilterWhere(['id'=>$ids])
            ->with(['settings' => function (Query $query) {
                $query->emulateExecution();
            }])
            ->asArray()
            ->all();
        $properties = [];
        foreach ($list as $propertyRecord) {
            $properties[] = $this->objectMapper->map($propertyRecord, Property::class);
        }
        return $properties;
    }

    /**
     * @param int $id
     * @return Property
     */
    public function find(int $id): Property
    {
        $propertyRecord = PropertyRecord::find()
            ->where(['id' => $id])
            ->with(['settings' => function (Query $query) {
                $query->emulateExecution();
            }])
            ->asArray()
            ->one();
        return $this->objectMapper->map($propertyRecord, Property::class);
    }

    public function remove(int $id): void
    {
        PropertyRecord::deleteAll(['id' => $id]);
        PropertiesSettingsRecord::deleteAll(['property_id' => $id]);
        ProductAttributesRecord::deleteAll(['property_id' => $id]);
    }
}