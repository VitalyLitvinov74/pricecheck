<?php

namespace app\modules\adminPanelSettings\application;

use app\modules\adminPanelSettings\domain\Models\ColumnSetting;
use app\modules\adminPanelSettings\domain\Models\ColumnOf;
use app\modules\adminPanelSettings\domain\Models\SettingType;
use app\modules\adminPanelSettings\Infrastructure\repositories\TableSettingsRepository;

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
                    $DTO->propertyId,
                    ColumnOf::from($DTO->propertyTypeOfEntity)
                )
            );
        }
        $this->repository->save($productList);
    }
}