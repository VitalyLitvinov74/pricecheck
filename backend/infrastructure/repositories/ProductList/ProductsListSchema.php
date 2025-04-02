<?php

namespace app\infrastructure\repositories\ProductList;

use app\domain\ProductList\Models\ColumnSetting;
use app\domain\ProductList\Models\SettingType;
use app\domain\ProductList\ProductList;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;

trait ProductsListSchema
{
    public function schema(): Schema
    {
        return new Schema([

            'product_list' => [
                Schema::ENTITY => ProductList::class,
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
                Schema::TABLE => 'admin_panel_product_list_settings',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                    'type',
                    'value',
                    'propertyId' => 'property_id',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'type' => SettingType::class,
                    'value' => 'int',
                    'propertyId' => 'int',
                ]
            ]
        ]);
    }
}