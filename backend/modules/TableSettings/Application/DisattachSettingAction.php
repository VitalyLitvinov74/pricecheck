<?php

namespace app\modules\TableSettings\Application;

use app\modules\TableSettings\Infrastructure\Repositories\ProductListRepository;

class DisattachSettingAction
{
    public function __construct(
        private ProductListRepository $repository = new ProductListRepository()
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