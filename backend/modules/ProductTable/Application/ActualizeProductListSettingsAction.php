<?php

namespace app\modules\ProductTable\Application;

use app\modules\ProductTable\Domain\Models\ColumnSetting;
use app\modules\ProductTable\Domain\Models\SettingType;
use app\modules\ProductTable\Infrastructure\Repositories\ProductListRepository;

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