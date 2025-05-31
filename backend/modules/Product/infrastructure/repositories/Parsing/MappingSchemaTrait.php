<?php

namespace app\modules\Product\infrastructure\repositories\Parsing;

use app\domain\Type;
use app\modules\Product\domain\Parsing\Models\MappingPair;
use app\modules\Product\domain\Parsing\Models\MappingSchema;
use app\modules\Product\domain\Parsing\Models\Property;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;

trait MappingSchemaTrait
{
    public function schema(): Schema
    {
        return new Schema([
            'mapping_schema' => [
                Schema::ENTITY => MappingSchema::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'parsing_schemas',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                    'startWithRowNum' => 'start_with_row_num',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'startWithRowNum' => 'int',
                ],
                Schema::RELATIONS => [
                    'mappingPairs' => [
                        Relation::TARGET => 'mapping_pair',
                        Relation::LOAD => Relation::LOAD_EAGER,
                        Relation::TYPE => Relation::HAS_MANY,
                        Relation::SCHEMA => [
                            Relation::INNER_KEY => 'id',
                            Relation::OUTER_KEY => 'schema_id',
                            Relation::CASCADE => true,
                            Relation::NULLABLE => false
                        ],
                    ]
                ],
            ],
            'mapping_pair' => [
                Schema::ENTITY => MappingPair::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'parsing_schema_properties',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                    'property_id',
                    'externalName' => 'external_field_name',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'externalName' => 'string',
                ],
                Schema::RELATIONS => [
                    'property' => [
                        Relation::TARGET => 'property',
                        Relation::LOAD => Relation::LOAD_EAGER,
                        Relation::TYPE => Relation::BELONGS_TO,
                        Relation::SCHEMA => [
                            Relation::INNER_KEY => 'property_id',
                            Relation::OUTER_KEY => 'id',
                        ]
                    ]
                ]
            ],
            'property' => [
                Schema::ENTITY => Property::class,
                Schema::MAPPER => Mapper::class,
                Schema::TABLE => 'properties',
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS => [
                    'id',
                    'type' => 'type_id',
                ],
                Schema::TYPECAST => [
                    'id' => 'int',
                    'type' => Type::class,
                ],
            ]
        ]);
    }
}