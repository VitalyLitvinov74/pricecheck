<?php

namespace app\infrastructure\repositories\ProductTemplate;

use app\domain\Product\SubDomains\Property\Models\Setting;
use app\domain\ProductTemplate\Models\Property;
use app\domain\ProductTemplate\Models\ValueType;
use app\domain\ProductTemplate\Product;
use app\infrastructure\repositories\ProductTemplate\pivots\ProductTemplatesProperties;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;
use Cycle\ORM\SchemaInterface;

trait ProductTemplateSchema
{
    private function schema(): Schema
    {
        return new Schema([
            'product' => [
                Schema::ENTITY => Product::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'product_templates',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                ],
                Schema::RELATIONS => [
                    'properties' => [
                        Relation::TYPE => Relation::HAS_MANY,
                        Relation::TARGET => 'property',
                        Relation::SCHEMA => [
                            Relation::CASCADE => true,
                            Relation::NULLABLE => false,
                            Relation::INNER_KEY => 'id',
                            Relation::OUTER_KEY => 'product_template_id',
                        ],
                        Relation::LOAD => Relation::LOAD_EAGER
                    ],
                ],
            ],
            'property' => [
                Schema::ENTITY => Property::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'properties',
                Schema::PRIMARY_KEY => ['id'],
                Schema::COLUMNS => [
                   'id',
                   'name',
                   'availableValueType' => 'type',
                    'product_template_id'
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'name' => 'string',
                    'availableValueType' => ValueType::class
                ],
            ],
        ]);
    }
}