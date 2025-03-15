<?php

namespace app\infrastructure\repositories\property;

use app\domain\Property\Property;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Yii;

class PropertyRepository
{
    private ORM $orm;
    private EntityManager $em;
    public function __construct()
    {
        $this->orm = Yii::$app->cycle->orm(PropertySchema::build());
        $this->em = new EntityManager($this->orm);
    }

    public function findBy(int $id): Property
    {
        $property = $this->orm->getRepository(Property::class)->findByPK($id);
        return $property;
    }

    public function save(Property $property): void
    {
        $this->em->persist($property);
        try {
            $this->em->run();
        } catch (\Throwable $e){
            $dd ='';
        }
    }
}