<?php

namespace app\modules\Product\domain\ParceDocument\Models;

class CardProperty
{
    public function __construct(
        private string $id,
        private mixed $value
    ) {}
}