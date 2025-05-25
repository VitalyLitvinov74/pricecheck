<?php

namespace app\modules\Product\domain\ParceDocument\Persistance\Snapshots;

class ProductCardPropertySnapshot
{
    public function __construct(
        public int $id,
        public mixed $value
    )
    {
    }
}