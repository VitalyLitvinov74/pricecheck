<?php

namespace app\domain\Property;

use app\domain\Property\Models\Setting;
use app\domain\Property\Models\SettingVO;
use app\domain\Type;
use Doctrine\Common\Collections\ArrayCollection;

class Property
{
    private int $id;

    private Type $type;

    /** @var ArrayCollection<int, Setting> $settings */
    private ArrayCollection $settings;

    public function __construct(
        private string $name,
        string $type
    )
    {
        $this->type = Type::from($type);
        $this->settings = new ArrayCollection();
    }

    public function change(Type $newType): void
    {
        $this->type = $newType;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function hasName(string $name): bool
    {
        return strtolower($this->name) === strtolower($name);
    }

    public function hasId(int $id): bool
    {
        return $id === $this->id;
    }

    public function attach(SettingVO $settingVO): void
    {
        $existedSetting = $this->settings->findFirst(
            function ($key, Setting $existedSetting) use ($settingVO) {
                return $existedSetting->is($settingVO->type) && $existedSetting->belongTo($settingVO->userId);
            }
        );
        if ($existedSetting !== null) {
            $existedSetting->change($settingVO->value);
            return;
        }
        $setting = new Setting($settingVO);
        $this->settings->add($setting);
    }

    public function disAttach(SettingVO $settingVO): void
    {
        foreach ($this->settings as $setting) {
            if ($setting->is($settingVO->type) && $setting->belongTo($settingVO->userId)) {
                $this->settings->removeElement($setting);
            }
        }
    }
}