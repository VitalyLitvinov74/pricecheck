<?php

namespace app\modules\UserSettings\application;

use app\modules\UserSettings\domain\Models\ColumnSetting;
use app\modules\UserSettings\domain\Models\ColumnOf;
use app\modules\UserSettings\domain\Models\SettingType;
use app\modules\UserSettings\Infrastructure\repositories\UserRepository;

class UpsertSettingAction
{
    public function __construct(private UserRepository $repository = new UserRepository())
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