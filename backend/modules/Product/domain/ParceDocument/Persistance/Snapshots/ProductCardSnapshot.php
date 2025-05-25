<?php

namespace app\modules\Product\domain\ParceDocument\Persistance\Snapshots;

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