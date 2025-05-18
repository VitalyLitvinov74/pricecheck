<?php

namespace app\modules\UserSettings\infrastructure\repositories;

use app\components\cycle\Cycle;
use app\modules\UserSettings\domain\Models\EntityType;
use app\modules\UserSettings\domain\User;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Yii;

class UserRepository
{
    use UserSchema;

    private ORM $orm;
    private EntityManager $em;

    public function __construct(Cycle $cycle)
    {
        $this->orm = $cycle->orm($this->schema());
        $this->em = new EntityManager($this->orm);
    }

    public function findBy(int $userId): User
    {
        return $this->orm
            ->getRepository(User::class)
            ->select()
            ->where('id', $userId)
            ->fetchOne();
    }

    public function save(User $user): void
    {
        try {
            $this->em->persist($user);
            $this->em->run();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}