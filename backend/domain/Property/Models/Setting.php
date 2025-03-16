<?php

namespace app\domain\Property\Models;

class Setting
{
    public function __construct(private SettingValue $settingVO)
    {
    }

    public function change(SettingValue $settingVO): void
    {
        $this->settingVO = $settingVO;
    }

    public function compareIdentity(SettingValue $settingVO): bool
    {
        return $this->settingVO->compareWith($settingVO);
    }
}