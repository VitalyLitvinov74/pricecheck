<?php

namespace app\domain\ProductList;

use app\domain\ProductList\Models\ColumnSetting;
use Doctrine\Common\Collections\ArrayCollection;

class ProductList
{
    private int $id;

    /** @var ArrayCollection<int, ColumnSetting> */
    private ArrayCollection $settings;

    public function __construct(private int $userId)
    {

    }

    public function upsertSetting(ColumnSetting $setting): void
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
     * @param ColumnSetting[] $settings
     * @return void
     */
    public function actualizeSettings(array $settings): void
    {
        $forRemove = $this->settings->filter(
            function (ColumnSetting $setting) use ($settings) {
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
            function (ColumnSetting $setting) use ($id) {
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