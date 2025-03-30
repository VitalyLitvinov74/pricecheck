<?php

namespace app\infrastructure\repositories\ProductTemplate;

use app\domain\Product\SubDomains\Property\Models\PropertySettingType;
use app\domain\Product\SubDomains\Property\Models\Setting;
use app\domain\Product\SubDomains\Property\Models\SettingValue;
use app\domain\Product\SubDomains\Property\Property;
use app\domain\ProductTemplate\Product;
use app\domain\Type;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;

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
                    Relation::TARGET => Property::class,
                    Relation::SCHEMA => [
                        Relation::CASCADE => true,
                        Relation::THROUGH_INNER_KEY,
                        Relation::THROUGH_OUTER_KEY,
                        Relation::T

                        Relation::INNER_KEY => 'id',
                        Relation::OUTER_KEY => 'property_id',
                    ],
                    Relation::LOAD => Relation::LOAD_EAGER
                ],
            ],
        ],
        Property::class => [
            Schema::ENTITY => Setting::class,
            Schema::MAPPER => Mapper::class,
            Schema::TABLE => 'properties_settings',
            Schema::PRIMARY_KEY => ['property_id'],
            Schema::COLUMNS => [
                'property_id',
                'value',
                'setting_type_id',
                'user_id',
            ],
            Schema::RELATIONS => [
                'settingVO' => [
                    Relation::TYPE => Relation::EMBEDDED,
                    Relation::TARGET => 'settingVO',
                    Relation::SCHEMA => [],
                    Relation::LOAD => Relation::LOAD_EAGER,
                ]
            ],
        ],
    ]);
    }
}