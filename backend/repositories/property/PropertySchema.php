<?php

namespace app\repositories\property;

use app\domain\Product\SubDomains\Property\Models\PropertySettingType;
use app\domain\Product\SubDomains\Property\Models\Setting;
use app\domain\Product\SubDomains\Property\Models\SettingValue;
use app\domain\Product\SubDomains\Property\Property;
use app\domain\Type;
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
                Schema::TABLE => 'properties',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                    'type'
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'type' => Type::class
                ],
                Schema::RELATIONS => [
                    'settings' => [
                        Relation::TYPE => Relation::HAS_MANY,
                        Relation::TARGET => Setting::class,
                        Relation::SCHEMA => [
                            Relation::CASCADE => true,
                            Relation::INNER_KEY => 'id',
                            Relation::OUTER_KEY => 'property_id',
                        ],
                        Relation::LOAD => Relation::LOAD_EAGER
                    ],
                ],
            ],
            Setting::class => [
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
            'settingVO' => [
                Schema::TABLE => 'properties_settings',
                Schema::ENTITY => SettingValue::class,
                Schema::MAPPER => Mapper::class,
                Schema::PRIMARY_KEY => ['property_id', 'setting_type_id', 'user_id'],
                Schema::COLUMNS => [
                    'value',
                    'type' => 'setting_type_id',
                    'userId' => 'user_id',
                ],
                Schema::TYPECAST => [
                    'type' => PropertySettingType::class,
                    'userId' => 'int',
                    'value' => 'int',
                ],
            ],
        ]);
    }
}