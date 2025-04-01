<?php

namespace app\application\ProductListSettings;

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