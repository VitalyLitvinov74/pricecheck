<?php

namespace app\modules\TableSettings\Application;

class SettingDTO
{
    public function __construct(
        public int $propertyId,
        public int $type,
        public int $value
    )
    {
    }
}