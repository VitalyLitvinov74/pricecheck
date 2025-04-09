<?php

namespace app\modules\ProductTable\Application;

use app\modules\ProductTable\Infrastructure\Repositories\ProductListRepository;

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