<?php

namespace app\modules\UserSettings\application;

use app\modules\UserSettings\domain\Models\ColumnSetting;
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
    public function __invoke(int $userId, array $settingsDTOs): void
    {
        $productsList = $this->repository->findBy($userId);
        $settings = [];
        foreach ($settingsDTOs as $DTO){
            $setting = new ColumnSetting(
                $DTO->value,
                SettingType::from($DTO->type),
                $DTO->propertyId,
                ColumnOf::from($DTO->propertyTypeOfEntity)
            );
            $productsList->upsertSetting($setting);
            $settings[] = $setting;
        }

        $productsList->actualizeSettings($settings);
        $this->repository->save($productsList);
    }
}