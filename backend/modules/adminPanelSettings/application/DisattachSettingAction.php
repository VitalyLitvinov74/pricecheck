<?php

namespace app\modules\adminPanelSettings\application;

use app\modules\adminPanelSettings\Infrastructure\repositories\TableSettingsRepository;

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