<?php

namespace app\modules\TableSettings\Infrastructure\repositories;

use app\modules\TableSettings\domain\Models\ColumnSetting;
use app\modules\TableSettings\domain\Models\SettingType;
use app\modules\TableSettings\domain\Table;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;

trait ProductsListSchema
{
    public function schema(): Schema
    {
        return new Schema([

            'product_list' => [
                Schema::ENTITY => Table::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'admin_panel_settings',
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
                            Relation::OUTER_KEY => 'admin_panel_setting_id',
                            Relation::NULLABLE => false
                        ]
                    ]
                ]
            ],
            'settings' => [
                Schema::ENTITY => ColumnSetting::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'admin_panel_tables_settings',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                    'columnSettingType' => 'column_setting_type',
                    'value',
                    'relatedId' => 'related_id',
                    'admin_panel_setting_id'
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'columnSettingType' => SettingType::class,
                    'value' => 'int',
                    'relatedId' => 'int',
                ]
            ]
        ]);
    }
}