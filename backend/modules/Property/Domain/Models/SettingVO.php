<?php

namespace app\modules\Property\Domain\Models;

readonly class SettingVO
{
    public function __construct(
        public PropertySettingType $type,
        public int $userId,
        public int $value
    )
    {
    }
}