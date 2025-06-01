<?php

namespace app\modules\Product\application\Product\EventHandlers;

use app\components\eventBus\EventName;
use app\forms\Scenarious;
use app\modules\Product\application\Product\ProductService;
use app\modules\Product\presentation\forms\ProductForm;

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

        //Если и должен быть какой то парсинг то только тут.
        $form->load($data);
        if ($form->validate()) {
            $this->service->create($form->attributeDTOs());
        }
    }
}