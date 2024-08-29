<?php

namespace app\domain\Product\Persistence\Snapshots;

use app\domain\Product\Models\Attribute;

class ProductSnapshot
{
    /**
     * @param $id
     * @param PropertySnapshot[] $properties
     */
    public function __construct(
        public $id,
        public array $properties
    )
    {
    }
}