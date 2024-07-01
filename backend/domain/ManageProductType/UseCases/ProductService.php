<?php

namespace app\domain\ManageProductType\UseCases;

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
        foreach ($form->cardFields as $field){
            $productCard->addField(
                $field->name,
                $field->type
            );
        }
        $this->productCardRepository->save($productCard);
    }
}