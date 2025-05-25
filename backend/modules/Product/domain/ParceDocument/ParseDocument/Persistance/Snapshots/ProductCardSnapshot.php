<?php

namespace app\modules\Product\domain\ParceDocument\ParseDocument\Persistance\Snapshots;

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