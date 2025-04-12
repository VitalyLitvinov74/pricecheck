<?php

namespace app\modules\adminPanelSettings\application;

use app\modules\adminPanelSettings\domain\Models\ColumnSetting;
use app\modules\adminPanelSettings\domain\Models\ColumnOf;
use app\modules\adminPanelSettings\domain\Models\SettingType;
use app\modules\adminPanelSettings\infrastructure\repositories\TableSettingsRepository;

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
                ColumnOf::from($DTO->propertyTypeOfEntity)
            );
            $productsList->upsertSetting($setting);
            $settings[] = $setting;
        }

        $productsList->actualizeSettings($settings);
        $this->repository->save($productsList);
    }
}