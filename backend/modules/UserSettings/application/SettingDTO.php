<?php

namespace app\modules\UserSettings\application;

class SettingDTO
{
    public function __construct(
        public int $id,
        public int $type,
        public int $intValue,
        public string $stringValue,
        public int $entityType,
        public int $entityId
    )
    {
    }
}