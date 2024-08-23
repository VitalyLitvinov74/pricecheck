<?php

namespace app\domain\ProductProperty\Persistence;

use app\collections\ProductPropertyCollection;
use app\domain\ProductProperty\Properties;
use app\libs\ObjectMapper\ObjectMapper;
use Yii;

class PropertyRepository
{
    public function __construct(
        private ObjectMapper  $objectMapper = new ObjectMapper(),
    )
    {
    }

    /**
     * @return string - id сохраненной записи
     */
    public function merge(Properties $properties): void
    {
        $data = $this->objectMapper->map($properties, []);
        Yii::$app->mongodb
            ->createCommand()
            ->batchInsert(
                ProductPropertyCollection::collectionName(),
                $data['collection'],
                ['upsert' => true]
            );
    }

    public function findAll(): Properties
    {
        $list = ProductPropertyCollection::find()->asArray()->all();
        $list = [
            "collection" => $list
        ];
        return $this->objectMapper->map($list, Properties::class);
    }
}