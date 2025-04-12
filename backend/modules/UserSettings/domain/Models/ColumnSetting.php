<?php

namespace app\modules\UserSettings\domain\Models;

class ColumnSetting
{
    private int $id;

    public function __construct(
        private int $value,
        private SettingType $columnSettingType,
        private int $propertyOfBusinessLogicEntityId,
        private ColumnOf $propertyTypeOfBusinessLogicEntity
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
        if ($setting->belongsTo($this->propertyOfBusinessLogicEntityId)
            && $setting->is($this->columnSettingType)) {
            return true;
        }
        return false;
    }

    public function is(SettingType $type): bool
    {
        return $this->columnSettingType === $type;
    }

    public function belongsTo(int $propertyId): bool
    {
        return $this->propertyOfBusinessLogicEntityId === $propertyId;
    }

    public function has(int $id): bool
    {
        return $this->id === $id;
    }
}