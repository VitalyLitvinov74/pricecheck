<?php

namespace app\modules\Product\domain\ParceDocument\ParseDocument\Persistance\Snapshots;

class ProductCardPropertySnapshot
{
    public function __construct(
        public int $id,
        public mixed $value
    )
    {
    }
}