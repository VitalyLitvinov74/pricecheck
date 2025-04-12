<?php

namespace app\modules\UserSettings\infrastructure\repositories;

use app\modules\UserSettings\domain\Models\AdminPanelEntityType;
use app\modules\UserSettings\domain\User;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Yii;

class UserRepository
{
    use UserSchema;

    private ORM $orm;
    private EntityManager $em;

    public function __construct()
    {
        $this->orm = Yii::$app->cycle->orm($this->schema());
        $this->em = new EntityManager($this->orm);
    }

    public function findBy(int $userId): User
    {
        return $this->orm
            ->getRepository(User::class)
            ->findOne(['user_id' => $userId, 'type' => AdminPanelEntityType::Table]);
    }

    public function save(User $productList): void
    {
        try {
            $this->em->persist($productList);
            $this->em->run();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}