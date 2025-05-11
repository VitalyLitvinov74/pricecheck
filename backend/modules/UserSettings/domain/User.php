<?php

namespace app\modules\UserSettings\domain;

use app\modules\UserSettings\domain\Models\Setting;
use Doctrine\Common\Collections\ArrayCollection;

class User
{
    private int $id;

    /** @var ArrayCollection<int, Setting> */
    private ArrayCollection $settings;

    private function __construct()
    {

    }

    public function upsertSetting(Setting $setting): void
    {
        foreach ($this->settings as $settingItem) {
            if ($settingItem->equalsTo($setting)) {
                $setting->copyValueTo($settingItem);
                return;
            }
        }
        $this->settings->add($setting);
    }

    /**
     * @param Setting[] $settings
     * @return void
     */
    public function actualizeSettings(array $settings): void
    {
        $forRemove = $this->settings->filter(
            function (Setting $setting) use ($settings) {
                foreach ($settings as $settingItem) {
                    if ($setting->equalsTo($settingItem)) {
                        return false;
                    }
                }
                return true;
            }
        );

        foreach ($forRemove as $setting) {
            $this->settings->removeElement($setting);
        }
    }

    public function disattachSetting(int $id): void
    {
        $setting = $this->settings->findFirst(
            function (Setting $setting) use ($id) {
                if($setting->has($id)){
                    return true;
                }
                return false;
            }
        );
        if(!$setting){
            return;
        }
        $this->settings->removeElement($setting);
    }
}