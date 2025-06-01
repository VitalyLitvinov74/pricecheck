<?php

namespace app\modules\Product\application\Product\EventHandlers;

use app\modules\Product\application\Product\ProductService;
use app\modules\Product\presentation\forms\ProductForm;

class ProductParsedHandler
{
    private $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }

    public function __invoke(array $data): void
    {
        $form = new ProductForm();
        $form->load($data);
        if ($form->validate()) {
            $this->service->create($form->attributeDTOs());
        }

    }
}