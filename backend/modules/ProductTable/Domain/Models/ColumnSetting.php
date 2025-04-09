<?php

namespace app\modules\ProductTable\Domain\Models;

class ColumnSetting
{
    private int $id;

    public function __construct(
        private int $value,
        private SettingType $type,
        private int $propertyId
    )
    {
    }

    public function changeTo(int $newValue): void
    {
        $this->value = $newValue;
    }

    public function copyValueTo(ColumnSetting $setting): void
    {
        $setting->changeTo($this->value);
    }

    public function equalsTo(ColumnSetting $setting): bool
    {
        if ($setting->belongsTo($this->propertyId) && $setting->is($this->type)) {
            return true;
        }
        return false;
    }

    public function is(SettingType $type): bool
    {
        return $this->type === $type;
    }

    public function belongsTo(int $propertyId): bool
    {
        return $this->propertyId === $propertyId;
    }

    public function has(int $id): bool
    {
        return $this->id === $id;
    }
}