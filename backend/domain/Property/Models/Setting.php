<?php

namespace app\domain\Property\Models;

class Setting
{
    public function __construct(private SettingVO $settingVO)
    {
    }

    public function change(SettingVO $settingVO): void
    {
        $this->settingVO = $settingVO;
    }

    public function compareIdentity(SettingVO $settingVO): bool
    {
        return $this->settingVO->compareWith($settingVO);
    }
}