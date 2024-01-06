<?php

namespace app\services;

use app\domain\ManageProductType\Persistence\ProductCardRepository;
use app\domain\ManageProductType\ProductType;
use app\forms\ProductTypeForm;

class ProductService
{
    public function __construct(
        private ProductCardRepository $productCardRepository = new ProductCardRepository()
    )
    {
    }

    public function createProductType(ProductTypeForm $form): void
    {
        $productCard = new ProductType($form->title);
        foreach ($form->properties as $field){
            $productCard->addField($field->name);
        }
        $this->productCardRepository->save($productCard);
    }
}