<?php

namespace app\services;

use app\domain\ManageProductType\Persistence\ProductTypeRepository;
use app\domain\ManageProductType\ProductCard;
use app\forms\CardForm;

class ProductService
{
    public function __construct(
        private ProductTypeRepository $productTypeRepository = new ProductTypeRepository()
    )
    {
    }

    public function createProductCard(CardForm $form): void
    {
        $productCard = new ProductCard($form->name);
        foreach ($form->fields as $field){
            $productCard->addField($field->name, $field->type);
        }
        $this->productTypeRepository->save($productCard);
    }
}