<?php

namespace app\modules\Property\Application;

readonly class SettingDTO
{
    public function __construct(public int $type, public int $value)
    {
    }
}