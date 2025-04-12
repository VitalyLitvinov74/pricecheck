<?php

namespace app\modules\adminPanelSettings\application;

use app\modules\adminPanelSettings\Infrastructure\repositories\AdminPanelRepository;

class DisattachSettingAction
{
    public function __construct(
        private AdminPanelRepository $repository = new AdminPanelRepository()
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