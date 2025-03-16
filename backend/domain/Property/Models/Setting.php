<?php

namespace app\domain\Property\Models;

class Setting
{
//    private PropertySettingType $type;
//    private int $userId;
//    private int $value;

    public function __construct(private SettingVO $settingVO)
    {
    }

    public function is(PropertySettingType $type): bool
    {
        return $this->settingVO->type === $type;
    }

    public function belongTo(int $userId): bool
    {
        return $this->settingVO->userId === $userId;
    }

    public function change(int $newValue): void
    {
        $this->settingVO = new SettingVO(
            $this->settingVO->type,
            $this->settingVO->userId,
            $newValue
        );
    }
}