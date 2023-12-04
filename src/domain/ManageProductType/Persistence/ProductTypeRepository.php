<?php

namespace app\domain\ManageProductType\Persistence;

use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;

class ProductTypeRepository
{
    public function __construct(
        private UpsertBuilder $upsertBuilder = new UpsertBuilder(),
        ObjectMapper $objectMapper = new ObjectMapper()
    )
    {
    }


}