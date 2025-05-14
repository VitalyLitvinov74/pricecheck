<?php

namespace app\domain\Product\Persistence;

use app\modules\Product\domain\Models\Attribute;
use app\modules\Product\domain\Models\Property;
use app\modules\Product\domain\Product;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;

trait ProductMappingSchema
{
    private function schemna(): Schema{
        return new Schema([
            'product' => [
                Schema::ENTITY => Product::class,
                Schema::MAPPER => Mapper::class,
//                Schema::DATABASE => 'postgres',
                Schema::TABLE => 'products',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id' => 'id',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                ],
                Schema::RELATIONS => [
                    'attributes' => [
                        Relation::TYPE => Relation::HAS_MANY,
                        Relation::TARGET => 'attribute',
                        Relation::SCHEMA => [
                            Relation::CASCADE => true,
                            Relation::INNER_KEY => 'product_id',
                            Relation::OUTER_KEY => 'id',
                        ],
                    ],
                ],
            ],
            'attribute' => [
                Schema::ENTITY => Attribute::class,
                Schema::MAPPER => Mapper::class,
//                Schema::DATABASE => 'postgres',
                Schema::TABLE => 'product_attributes',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id' => 'id',
                    'value' => 'value',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'value' => 'string'
                ],
                Schema::RELATIONS => [
                    'property' => [
                        Relation::TYPE => Relation::HAS_ONE,
                        Relation::TARGET => 'property',
                        Relation::SCHEMA => [
                            Relation::CASCADE => true,
                            Relation::INNER_KEY => 'property_id',
                            Relation::OUTER_KEY => 'id',
                        ],
                    ],
                ],
            ],
            'property' => [
                Schema::ENTITY => Property::class,
                Schema::MAPPER => Mapper::class,
//                Schema::DATABASE => 'postgres',
                Schema::TABLE => 'properties',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id' => 'id',
                    'name' => 'name',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'name' => 'string'
                ],
            ]
        ]);
    }
}