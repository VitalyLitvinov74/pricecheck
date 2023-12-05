<?php

namespace app\domain\ManageProductType\Persistence;

use app\domain\ManageProductType\ProductCard;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;

class ProductTypeRepository
{
    public function __construct(
        private UpsertBuilder $upsertBuilder = new UpsertBuilder(),
        private ObjectMapper $objectMapper = new ObjectMapper()
    )
    {
    }

    public function save(ProductCard $productType): void
    {

    }


}