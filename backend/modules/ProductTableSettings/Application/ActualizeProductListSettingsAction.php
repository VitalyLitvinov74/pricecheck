<?php

namespace app\modules\ProductTableSettings\Application;

use app\modules\ProductTableSettings\Domain\Models\ColumnSetting;
use app\modules\ProductTableSettings\Domain\Models\SettingType;
use app\modules\ProductTableSettings\Infrastructure\Repositories\ProductListRepository;

class ActualizeProductListSettingsAction
{

    private ProductListRepository $repository;

    public function __construct()
    {
        $this->repository = new ProductListRepository();
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