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
        $productsList->actualizeSettings(
            array_map(
                function (SettingDTO $DTO) {
                    return new ColumnSetting(
                        $DTO->propertyId,
                        SettingType::from($DTO->type),
                        $DTO->value
                    );
                },
                $settingsDTOs
            )
        );
        $this->repository->save($productsList);
    }
}