<?php

namespace app\modules\Product\infrastructure\repositories\Product;

use app\components\cycle\Cycle;
use app\modules\Product\domain\Product\Product;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Yii;

class ProductPgRepository
{
    use SchemaTrait;

    private EntityManager $em;
    private ORM $ORM;

    public function __construct()
    {
        $this->ORM = Yii::$app->cycle->orm($this->schema());
        $this->em = new EntityManager($this->ORM);
    }

    public function save(Product $product): int
    {
        $this->em->persist($product);
        $this->em->run();
        return $this->ORM->getHeap()->get($product)->getData()['id'];
    }
}