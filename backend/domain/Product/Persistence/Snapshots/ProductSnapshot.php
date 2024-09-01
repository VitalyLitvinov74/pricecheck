<?php

namespace app\domain\Product\Persistence\Snapshots;

class ProductSnapshot
{
    /**
     * @param int|null $id
     * @param AttributeSnapshot[] $attributesSnapshots
     */
    public function __construct(
        public int|null $id,
        public array $attributesSnapshots
    )
    {
    }
}