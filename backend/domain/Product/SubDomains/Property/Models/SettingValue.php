<?php

namespace app\domain\Product\SubDomains\Property\Models;

class SettingValue
{
    public function __construct(
        private PropertySettingType $type,
        private int $userId,
        private int $value
    )
    {
    }

    public function belongsTo(int $userId): bool
    {
        return $this->userId === $userId;
    }

    public function hasType(PropertySettingType $type): bool
    {
        return $this->type === $type;
    }

    public function checkValue(int $value): bool{
        return $this->value === $value;
    }

    public function compareWith(SettingValue $settingVO): bool
    {
        return $settingVO->hasType($this->type)
            && $settingVO->belongsTo($this->userId)
            && $settingVO->checkValue($this->value);
    }
}