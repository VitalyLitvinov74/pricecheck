<?php

namespace app\services;

use app\domain\ManageProductCard\Persistence\ProductCardRepository;
use app\domain\ManageProductCard\ProductCard;
use app\forms\CardForm;

class ProductService
{
    public function __construct(
        private ProductCardRepository $productCardRepository = new ProductCardRepository()
    )
    {
    }

    public function createProductCard(CardForm $form): void
    {
        $productCard = new ProductCard($form->name);
        foreach ($form->fields as $field){
            $productCard->addField($field->name, $field->type);
        }
        $this->productCardRepository->save($productCard);
    }
}