<?php

namespace app\modules\UserSettings\application;

use app\modules\UserSettings\Infrastructure\repositories\UserRepository;

class DisattachSettingAction
{
    public function __construct(
        private UserRepository $repository = new UserRepository()
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