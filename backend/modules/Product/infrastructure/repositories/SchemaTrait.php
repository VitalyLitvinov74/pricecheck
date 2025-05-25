<?php

namespace app\modules\Product\infrastructure\repositories;

use app\modules\Product\domain\Product\Models\Attribute;
use app\modules\Product\domain\Product\Product;
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
                Schema::TABLE => 'products',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                ],
                Schema::RELATIONS => [
                    'attributes' => [
                        Relation::TARGET => 'attribute',
                        Relation::LOAD => Relation::LOAD_EAGER,
                        Relation::TYPE => Relation::HAS_MANY,
                        Relation::SCHEMA => [
                            Relation::INNER_KEY => 'id',
                            Relation::OUTER_KEY => 'product_id',
                            Relation::CASCADE => true,
                            Relation::NULLABLE => false
                        ],

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
                    'value',
                    'product_id'
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