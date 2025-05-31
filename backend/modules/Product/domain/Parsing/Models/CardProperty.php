<?php

namespace app\modules\Product\domain\Parsing\Models;

class CardProperty
{
    public function __construct(
        private int $id,
        private mixed $value
    ) {}
}