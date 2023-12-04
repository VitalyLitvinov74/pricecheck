<?php

namespace app\services;

use app\domain\ManageProductType\Persistence\ProductTypeRepository;
use app\domain\ManageProductType\ProductType;
use app\forms\ProductForm;

class ProductService
{
    public function __construct(
        private ProductTypeRepository $productTypeRepository = new ProductTypeRepository()
    )
    {
    }

    public function createProductType(ProductForm $form): void
    {
        $productType = new ProductType($form->name);
        foreach ($form->fields as $field){
            $productType->addField($field['name'], $field['type']);
        }
        $this->productTypeRepository->save($productType);
    }
}