<?php

namespace app\domain\Property\Models;

class SettingVO
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

    public function compareWith(SettingVO $settingVO): bool
    {
        return $this->type === $settingVO->type && $this->userId === $settingVO->userId && $this->value === $settingVO->value;
    }
}