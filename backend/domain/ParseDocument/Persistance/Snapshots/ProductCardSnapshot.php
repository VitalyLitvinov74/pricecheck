<?php

namespace app\domain\ParseDocument\Persistance\Snapshots;

class ProductCardSnapshot
{
    /**
     * @param ProductCardPropertySnapshot[] $productCardPropertiesSnapshots
     */
    public function __construct(
        public array $productCardPropertiesSnapshots
    )
    {
    }
}