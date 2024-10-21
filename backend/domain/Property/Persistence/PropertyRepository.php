<?php

namespace app\domain\Property\Persistence;

use app\domain\Property\Properties;
use app\libs\LibsException;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\PropertiesRecord;

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
            ->useActiveRecord(PropertiesRecord::class)
            ->useUniqueKeys(['id'])
            ->upsertManyRecords($insertData);
        $actualNames = [];
        foreach ($data['collection'] as $property){
            if($property['name']){
                $actualNames[] = $property['name'];
            }
        }
        PropertiesRecord::deleteAll(['not in', 'name', $actualNames]);
    }

    public function findAll(): Properties
    {
        $list = PropertiesRecord::find()->asArray()->all();
        $list = [
            "collection" => $list
        ];
        return $this->objectMapper->map($list, Properties::class);
    }
}