<?php

namespace app\modules\Product\application\Product\EventHandlers;

use app\components\eventBus\EventName;
use app\forms\Scenarious;
use app\modules\Product\application\Product\ProductService;
use app\modules\Product\infrastructure\records\PropertyRecord;
use app\modules\Product\presentation\forms\ProductForm;
use yii\helpers\ArrayHelper;

class ProductParsedHandler
{
    private $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }

    /**
     * @see EventName::ProductParsedFromFile
     * @param string $eventName
     * @param array $data
     * @return void
     */
    public function __invoke(string $eventName, array $data): void
    {
        $form = new ProductForm([
            'scenario' => Scenarious::CreateProduct
        ]);

        $propertiesIds = ArrayHelper::getColumn($data['attributes'], 'propertyId');
        $properties = PropertyRecord::find()
            ->where(['id' => $propertiesIds])
            ->asArray()
            ->all();

        $attributes = [];
        foreach ($data['attributes'] as $attribute){
            foreach ($properties as $property){
                if($property['id'] === $attribute['propertyId']){
                    $attribute['propertyName'] = $property['name'];
                    break;
                }
            }
            $attributes[] = $attribute;
        }

        $data['attributes'] = $attributes;

        //Если и должен быть какой то парсинг то только тут.
        $form->load($data);
        if ($form->validate()) {
            $this->service->create(
                $form->attributeDTOs()
            );
        }
    }
}