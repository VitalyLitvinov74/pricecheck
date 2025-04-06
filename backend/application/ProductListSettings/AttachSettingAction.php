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
    
    public function __invoke(int $userId, SettingDTO $DTO): void
    {
        $productList = $this->repository->findBy($userId);
        $productList->upsertSetting(
            new ColumnSetting(
                $DTO->value,
                SettingType::from($DTO->type),
                $DTO->propertyId
            )
        );
        $this->repository->save($productList);
    }
}