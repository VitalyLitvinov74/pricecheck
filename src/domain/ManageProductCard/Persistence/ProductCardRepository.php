<?php

namespace app\domain\ManageProductCard\Persistence;

use app\domain\ManageProductCard\ProductCard;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\ProductCardsCollection;
use Yii;

class ProductCardRepository
{
    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper()
    )
    {
    }

    public function save(ProductCard $productType): void
    {
        $data = $this->objectMapper->map($productType, []);
        ProductCardsCollection::getCollection()->insert($data);
    }


}