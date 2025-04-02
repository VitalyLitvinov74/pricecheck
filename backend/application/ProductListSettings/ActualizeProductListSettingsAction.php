<?php

namespace app\application\ProductListSettings;

use app\domain\ProductList\Models\ColumnSetting;
use app\domain\ProductList\Models\SettingType;
use app\infrastructure\repositories\ProductList\ProductListRepository;

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