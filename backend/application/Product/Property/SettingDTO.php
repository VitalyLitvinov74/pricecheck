<?php

namespace app\application\Product\Property;

readonly class SettingDTO
{
    public function __construct(public int $type, public int $value)
    {
    }
}