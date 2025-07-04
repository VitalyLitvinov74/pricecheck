<?php

namespace app\modules\UserSettings\application;

use app\modules\UserSettings\domain\Models\Setting;
use app\modules\UserSettings\domain\Models\ColumnOf;
use app\modules\UserSettings\domain\Models\SettingType;
use app\modules\UserSettings\infrastructure\repositories\UserRepository;

class ActualizeProductListSettingsAction
{

    private UserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    /**
     * @param int $userId
     * @param SettingDTO[] $settingsDTOs
     * @return void
     * @throws \Exception
     */
    public function __invoke(): void
    {
        $user = $this->repository->findBy($userId);
        $settings = [];
        foreach ($settingsDTOs as $DTO){
            $setting = new Setting(
                $DTO->value,
                SettingType::from($DTO->type),
                $DTO->propertyId,
                ColumnOf::from($DTO->propertyTypeOfEntity)
            );
            $user->upsertSetting($setting);
            $settings[] = $setting;
        }
        $this->repository->save($user);
    }
}