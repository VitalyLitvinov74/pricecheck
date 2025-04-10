<?php

namespace app\modules\TableSettings\infrastructure\repositories;

use app\modules\TableSettings\domain\Table;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Yii;

class TableSettingsRepository
{
    use ProductsListSchema;

    private ORM $orm;
    private EntityManager $em;

    public function __construct()
    {
        $this->orm = Yii::$app->cycle->orm($this->schema());
        $this->em = new EntityManager($this->orm);
    }

    public function findBy(int $userId): Table
    {
        return $this->orm
            ->getRepository(Table::class)
            ->findOne(['user_id' => $userId]);
    }

    public function save(Table $productList): void
    {
        try {
            $this->em->persist($productList);
            $this->em->run();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}