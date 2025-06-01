<?php

namespace app\modules\Product\infrastructure\mappers;

use app\modules\Product\domain\Parsing\Models\CartAttribute;
use app\modules\Product\domain\Parsing\Models\ProductCard;
use Cycle\ORM\EntityManager;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\MapperInterface;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;
use Yii;

class ProductCardToArray
{
    private MapperInterface $mapper;

    public function __construct(private ProductCard $productCard)
    {

        $orm = Yii::$app->cycle->orm($this->schema());
        $this->mapper = $orm->getMapper(ProductCard::class);

    }

    public function __invoke(): array
    {
        return $this->mapper->extract($this->productCard);
    }

    private function schema(): Schema
    {
        return new Schema([
            'product_card' => [
                Schema::ENTITY => ProductCard::class,
                Schema::TABLE => 'product_cards',
                Schema::MAPPER => Mapper::class,
                Schema::RELATIONS => [
                    'attributes' => [
                        Relation::TARGET => 'cart_attribute',
                        Relation::LOAD => Relation::LOAD_EAGER,
                        Relation::TYPE => Relation::HAS_MANY,
                    ]
                ],
                'cart_attribute' => [
                    Schema::ENTITY => CartAttribute::class,
                    Schema::MAPPER => Mapper::class,
                    Schema::TABLE => 'cart_attributes',
                ]
            ],
        ]);
    }
}