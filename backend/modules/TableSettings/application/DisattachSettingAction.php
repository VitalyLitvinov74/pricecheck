<?php

namespace app\modules\TableSettings\application;

use app\modules\TableSettings\Infrastructure\repositories\TableSettingsRepository;

class DisattachSettingAction
{
    public function __construct(
        private TableSettingsRepository $repository = new TableSettingsRepository()
    )
    {
    }
    
    public function __invoke(int $userId, int $id): void
    {
        $productList = $this->repository->findBy($userId);
        $productList->disattachSetting($id);
        $this->repository->save($productList);
    }
}