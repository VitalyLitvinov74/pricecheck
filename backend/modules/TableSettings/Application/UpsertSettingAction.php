<?php

namespace app\modules\TableSettings\Application;

use app\modules\TableSettings\Domain\Models\ColumnSetting;
use app\modules\TableSettings\Domain\Models\SettingType;
use app\modules\TableSettings\Infrastructure\Repositories\ProductListRepository;

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