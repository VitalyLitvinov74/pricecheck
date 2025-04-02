<?php

namespace app\infrastructure\repositories\ProductList;

use app\domain\ProductList\ProductList;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Yii;

class ProductListRepository
{
    use ProductsListSchema;

    private ORM $orm;
    private EntityManager $em;

    public function __construct()
    {
        $this->orm = Yii::$app->cycle->orm($this->schema());
        $this->em = new EntityManager($this->orm);
    }

    public function findBy(int $userId): ProductList
    {
        return $this->orm->getRepository(ProductList::class)->findOne(['user_id' => $userId]);
    }

    public function save(ProductList $productList): void
    {
        try {
            $this->em->persist($productList);
            $this->em->run();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}