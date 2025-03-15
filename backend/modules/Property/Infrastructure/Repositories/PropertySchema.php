<?php

namespace app\modules\Property\Infrastructure\Repositories;

use app\modules\Property\Domain\Property;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;

trait PropertySchema
{
    public function schema(): Schema
    {
        return new Schema([
            'property' => [
                Schema::ENTITY => Property::class,
                Schema::MAPPER => Mapper::class,
//                Schema::DATABASE => 'postgres',
                Schema::TABLE => 'properties',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id' => 'id',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                ],
                Schema::RELATIONS => [
                    'settings' => [
                        Relation::TYPE => Relation::HAS_MANY,
                        Relation::TARGET => 'settings',
                        Relation::SCHEMA => [
                            Relation::CASCADE => true,
                            Relation::INNER_KEY => 'product_id',
                            Relation::OUTER_KEY => 'id',
                        ],
                    ],
                ],
            ],
            'type' => [
                Schema::ENTITY => \app\domain\Product\Models\Property::class,
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