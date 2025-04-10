<?php

namespace app\modules\TableSettings\application;

class SettingDTO
{
    public function __construct(
        public int $propertyId,
        public int $type,
        public int $value,
        public int $entityType
    )
    {
    }
}