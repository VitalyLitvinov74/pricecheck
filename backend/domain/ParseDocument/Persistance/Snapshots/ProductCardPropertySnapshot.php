<?php

namespace app\domain\ParseDocument\Persistance\Snapshots;

class ProductCardPropertySnapshot
{
    public function __construct(
        public int $id,
        public mixed $value
    )
    {
    }
}