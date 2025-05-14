<?php

namespace app\modules\Product\infrastructure\repositories;

use app\modules\Product\domain\Models\Attribute;
use app\modules\Product\domain\Product;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;

trait SchemaTrait
{
    public function schema(): Schema
    {
        return new Schema([
            'product' => [
                Schema::ENTITY => Product::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'product',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                ],
                Schema::RELATIONS => [
                    'attributes' => [
                        Relation::TYPE => Relation::HAS_MANY,
                        Relation::TARGET => 'attribute',
                        Relation::INNER_KEY => 'id',
                        Relation::OUTER_KEY => 'product_id',
                    ]
                ]
            ],
            'attribute' => [
                Schema::ENTITY => Attribute::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'product_attributes',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                    'propertyId' => 'property_id',
                    'propertyName' => 'property_name',
                    'value'
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'propertyId' => 'int',
                    'propertyName' => 'string',
                    'value' => 'string',
                ],
            ],
        ]);
    }
}