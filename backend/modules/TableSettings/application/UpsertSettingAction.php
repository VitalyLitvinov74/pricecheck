<?php

namespace app\modules\TableSettings\application;

use app\modules\TableSettings\domain\Models\ColumnSetting;
use app\modules\TableSettings\domain\Models\SettingType;
use app\modules\TableSettings\Infrastructure\repositories\TableSettingsRepository;

class UpsertSettingAction
{
    public function __construct(private TableSettingsRepository $repository = new TableSettingsRepository())
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