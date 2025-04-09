<?php

namespace app\modules\ProductTable\Application;

use app\modules\ProductTable\Domain\Models\ColumnSetting;
use app\modules\ProductTable\Domain\Models\SettingType;
use app\modules\ProductTable\Infrastructure\Repositories\ProductListRepository;

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