<?php

namespace app\domain\ManageProductType\Persistence;

use app\domain\ManageProductType\ProductType;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\ProductCardsCollection;
use Yii;
use yii\mongodb\Exception;

class ProductCardRepository
{
    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper()
    )
    {
    }

    /**
     * @param  ProductType  $productType
     * @return string - id сохраненной записи
     * @throws Exception
     */
    public function save(ProductType $productType): string
    {
        $data = $this->objectMapper->map($productType, []);
        return ProductCardsCollection::getCollection()->insert($data);
    }


}