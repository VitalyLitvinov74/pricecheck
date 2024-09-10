<?php

namespace app\domain\Product\Persistence\Snapshots;

class  AttributeSnapshot
{
    public function __construct(
        public PropertySnapshot $propertySnapshot,
        public mixed $value,
        public int|null $id
    )
    {
    }
}