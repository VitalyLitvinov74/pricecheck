<?php

namespace app\domain\Product\Persistance\Snapshots;

use app\domain\Product\Models\Property;

class ProductSnapshot
{
    /**
     * @param $id
     * @param Property[] $properties
     */
    public function __construct(
        public $id,
        public array $properties
    )
    {
    }
}