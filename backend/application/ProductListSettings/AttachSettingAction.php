<?php

namespace app\application\ProductListSettings;

use app\domain\ProductList\Models\ColumnSetting;
use app\domain\ProductList\Models\SettingType;
use app\infrastructure\repositories\ProductList\ProductListRepository;

class AttachSettingAction
{
    public function __construct(private ProductListRepository $repository = new ProductListRepository())
    {
    }

    /**
     * @param int $userId
     * @param SettingDTO[] $DTOs
     * @return void
     * @throws \Exception
     */
    public function __invoke(int $userId, array $DTOs): void
    {
        $productList = $this->repository->findBy($userId);
        foreach ($DTOs as $DTO) {
            $productList->upsertSetting(
                new ColumnSetting(
                    $DTO->value,
                    SettingType::from($DTO->type),
                    $DTO->propertyId
                )
            );
        }
        $this->repository->save($productList);
    }
}