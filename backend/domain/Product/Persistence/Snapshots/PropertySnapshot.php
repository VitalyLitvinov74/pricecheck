<?php

namespace app\domain\Product\Persistence\Snapshots;

class PropertySnapshot
{
    public function __construct(
        public $id,
        public int $propertyId,
        public mixed $propertyValue,
        public string $propertyName
    )
    {
    }
}