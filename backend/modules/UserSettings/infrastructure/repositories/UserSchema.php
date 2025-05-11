<?php

namespace app\modules\UserSettings\Infrastructure\repositories;

use app\modules\UserSettings\domain\Models\EntityType;
use app\modules\UserSettings\domain\Models\Setting;
use app\modules\UserSettings\domain\Models\SettingType;
use app\modules\UserSettings\domain\User;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;

trait UserSchema
{
    public function schema(): Schema
    {
        return new Schema([
            'product_list' => [
                Schema::ENTITY => User::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'user',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                ],
                Schema::RELATIONS => [
                    'settings' => [
                        Relation::TYPE => Relation::HAS_MANY,
                        Relation::TARGET => 'settings',
                        Relation::LOAD => Relation::LOAD_EAGER,
                        Relation::SCHEMA => [
                            Relation::CASCADE => true,
                            Relation::INNER_KEY => 'id',
                            Relation::OUTER_KEY => 'user_id',
                            Relation::NULLABLE => false
                        ]
                    ]
                ]
            ],
            'settings' => [
                Schema::ENTITY => Setting::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'user_settings',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                    'user_id',
                    'type',
                    'intValue' => 'int_value',
                    'stringValue' => 'string_value',
                    'entityId' => 'entity_id',
                    'entityType' => 'entity_type',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'user_id' => 'int',
                    'type' => SettingType::class,
                    'intValue' => 'int',
                    'entityId' => 'int',
                    'entityType' => EntityType::class,
                    'stringValue' => 'string',
                ]
            ]
        ]);
    }
}