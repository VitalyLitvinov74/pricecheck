<?php

namespace app\modules\TableSettings\application;

use app\modules\TableSettings\domain\Models\ColumnSetting;
use app\modules\TableSettings\domain\Models\SettingType;
use app\modules\TableSettings\infrastructure\repositories\TableSettingsRepository;

class ActualizeProductListSettingsAction
{

    private TableSettingsRepository $repository;

    public function __construct()
    {
        $this->repository = new TableSettingsRepository();
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
            );
            $productsList->upsertSetting($setting);
            $settings[] = $setting;
        }

        $productsList->actualizeSettings($settings);
        $this->repository->save($productsList);
    }
}