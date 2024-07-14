<?php

namespace app\domain\ParseDocument\Models;

class CardProperty
{
    public function __construct(
        private string $name,
        private mixed $value
    ) {}
}