<?php

namespace app\domain\Property\Persistence;

use app\domain\Property\Properties;
use app\libs\LibsException;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\ProductPropertiesRecord;
use Yii;
use yii\base\InvalidConfigException;
use yii\mongodb\Exception;

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
     */
    public function merge(Properties $properties): void
    {
        $data = $this->objectMapper->map($properties, []);
        $insertData = $data['collection'];
        $this->upsertBuilder
            ->useActiveRecord(ProductPropertiesRecord::class)
            ->useUniqueKeys(['id'])
            ->upsertManyRecords($insertData);
        $actualIds = [];
        foreach ($data['collection'] as $property){
            $actualIds[] = $property['id'];
        }
        ProductPropertiesRecord::deleteAll(['not in', 'id', $actualIds]);
    }

    public function findAll(): Properties
    {
        $list = ProductPropertiesRecord::find()->asArray()->all();
        $list = [
            "collection" => $list
        ];
        return $this->objectMapper->map($list, Properties::class);
    }
}