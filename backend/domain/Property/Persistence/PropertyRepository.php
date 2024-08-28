<?php

namespace app\domain\Property\Persistence;

use app\collections\ProductPropertyCollection;
use app\domain\Property\Properties;
use app\libs\ObjectMapper\ObjectMapper;
use Yii;
use yii\base\InvalidConfigException;
use yii\mongodb\Exception;

class PropertyRepository
{
    public function __construct(
        private ObjectMapper  $objectMapper = new ObjectMapper(),
    )
    {
    }

    /**
     * @param Properties $properties
     * @return void - id сохраненной записи
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function merge(Properties $properties): void
    {
        $data = $this->objectMapper->map($properties, []);
        $command = Yii::$app->mongodb
            ->createCommand();
        foreach ($data['collection'] as $propertyData){
            $command->addUpdate(
                    [
                        '_id' => $propertyData['_id'],
                    ],
                    $propertyData,
                    ['upsert' => true]
                );
        }
       $command->executeBatch(ProductPropertyCollection::collectionName());
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