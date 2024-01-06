<?php

namespace app\domain\ManageProductType\Persistence;

use app\domain\ManageProductType\ProductType;
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

    public function save(ProductType $productType): void
    {
        $data = $this->objectMapper->map($productType, []);
        ProductCardsCollection::getCollection()->insert($data);
    }


}