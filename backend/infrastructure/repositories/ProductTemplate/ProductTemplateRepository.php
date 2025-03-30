<?php

namespace app\infrastructure\repositories\ProductTemplate;

use app\domain\ProductTemplate\Product;
use Cycle\ORM\EntityManager;

class ProductTemplateRepository
{
    use ProductTemplateSchema;
    private $orm;
    private $em;
    public function __construct()
    {
        $this->orm = \Yii::$app->cycle->orm($this->schema());
        $this->em = new EntityManager($this->orm);
    }

    public function find(): Product
    {
        return $this->orm->getRepository(Product::class)->findByPK(1);
    }

    public function save(Product $product): int
    {
        $this->em->persist($product);
        try {
            $this->em->run();
            return 1;
        } catch (\Throwable $e){
            throw $e;
        }
    }
}