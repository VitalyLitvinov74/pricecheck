<?php

namespace app\domain\Property\Models;

class SettingVO
{
    public function __construct(
        public PropertySettingType $type,
        public int $userId,
        public int $value
    )
    {
    }
}