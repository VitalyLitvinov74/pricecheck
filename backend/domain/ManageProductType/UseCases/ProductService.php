<?php

namespace app\domain\ManageProductType\UseCases;

use app\domain\ManageProductType\Persistence\ProductCardRepository;
use app\domain\ManageProductType\ProductType;
use app\forms\ProductTypeForm;
use yii\mongodb\Exception;

class ProductService
{
    public function __construct(
        private ProductCardRepository $productCardRepository = new ProductCardRepository()
    )
    {
    }

    /**
     * @param  ProductTypeForm  $form
     * @return string - id
     * @throws Exception
     */
    public function createProductType(ProductTypeForm $form): string
    {
        $productCard = new ProductType($form->title);
        foreach ($form->properties as $field){
            $productCard->addField(
                $field->name,
                $field->type
            );
        }
        return $this->productCardRepository->save($productCard);
    }
}