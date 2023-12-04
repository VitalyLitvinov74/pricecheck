<?php

namespace services;

use app\domain\ManageProductType\Persistence\ProductTypeRepository;
use app\domain\ProductMetadata\ProductType;
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
        foreach ($form->fields as $productFieldForm){
            $productType->addField($productFieldForm->name, $productFieldForm->type);
        }
        $this->productTypeRepository->save($productType);
    }
}