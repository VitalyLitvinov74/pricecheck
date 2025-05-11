<?php

namespace app\modules\UserSettings\domain\Models;

class Setting
{
    private int $id;

    public function __construct(
        private int $intValue,
        private string $stringValue,
        private SettingType $type,
        private int $entityId,
        private EntityType $entityType
    )
    {
    }

    public function changeTo(int $newIntValue, string $newStringValue): void
    {
        $this->intValue = $newIntValue;
        $this->stringValue = $newStringValue;
    }

    public function copyValueTo(Setting $setting): void
    {
        $setting->changeTo($this->intValue, $this->stringValue);
    }

    public function equalsTo(Setting $setting): bool
    {
        if (
            $setting->is($this->type)
            && $setting->belongsTo($this->entityId, $this->entityType)
        ) {
            return true;
        }
        return false;
    }

    public function is(SettingType $type): bool
    {
        return $this->type === $type;
    }

    public function has(int $id): bool
    {
        return $this->id === $id;
    }

    public function belongsTo(int $entityId, EntityType $entityType): bool
    {
        return $this->entityId === $entityId && $this->entityType === $entityType;
    }
}