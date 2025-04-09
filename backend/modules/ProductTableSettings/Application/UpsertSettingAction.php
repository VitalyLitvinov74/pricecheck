<?php

namespace app\modules\ProductTableSettings\Application;

use app\modules\ProductTableSettings\Domain\Models\ColumnSetting;
use app\modules\ProductTableSettings\Domain\Models\SettingType;
use app\modules\ProductTableSettings\Infrastructure\Repositories\ProductListRepository;

class UpsertSettingAction
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