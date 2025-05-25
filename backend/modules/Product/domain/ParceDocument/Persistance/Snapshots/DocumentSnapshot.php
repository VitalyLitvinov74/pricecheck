<?php

namespace app\modules\Product\domain\ParceDocument\Persistance\Snapshots;

class DocumentSnapshot
{
    /**
     * @param string $version
     * @param ProductCardSnapshot[] $productsCardsSnapshots
     */
    public function __construct(
        public string $version,
        public array $productsCardsSnapshots
    )
    {
    }
}