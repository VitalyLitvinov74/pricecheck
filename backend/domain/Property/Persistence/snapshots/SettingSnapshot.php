<?php

namespace app\domain\Property\Persistence\snapshots;

class SettingSnapshot
{
    public function __construct(
        public int|null $id,
        public int $type,
        public int $propertyId
    )
    {
    }
}