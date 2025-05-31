<?php

namespace app\modules\Product\domain\Parsing\Models;

class CartAttribute
{
    public function __construct(
        private int $propertyId,
        private mixed $value
    ) {}
}