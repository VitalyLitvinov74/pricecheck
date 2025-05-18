<?php

namespace app\modules\UserSettings\application;

use app\modules\UserSettings\domain\Models\Setting;
use app\modules\UserSettings\domain\Models\EntityType;
use app\modules\UserSettings\domain\Models\SettingType;
use app\modules\UserSettings\infrastructure\repositories\UserRepository;

class SettingsService
{
    public function __construct(private UserRepository $repository)
    {
    }

    /**
     * @param int $userId
     * @param SettingDTO[] $settingsDTOs
     * @return void
     * @throws \Exception
     */
    public function upsertUserSettings(int $userId, array $settingsDTOs): void{
        $user = $this->repository->findBy($userId);
        foreach ($settingsDTOs as $DTO){
            $setting = new Setting(
                $DTO->intValue,
                $DTO->stringValue,
                SettingType::from($DTO->type),
                $DTO->entityId,
                EntityType::from($DTO->entityType)
            );
            $user->upsertSetting($setting);
        }
        $this->repository->save($user);
    }
}