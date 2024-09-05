<?php

namespace app\domain\ParsingSchema\Persistence;

use app\collections\ParsingSchemas;
use app\collections\ProductPropertyCollection;
use app\domain\ParsingSchema\ParsingSchema;
use app\domain\ParsingSchema\Persistence\Snapshots\SchemaSnapshot;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\ParsingSchemaPropertiesRecord;
use app\records\ParsingSchemaRecord;
use MongoDB\BSON\ObjectId;

class ParsingSchemaRepository
{
    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper(),
        private UpsertBuilder $upsertBuilder = new UpsertBuilder()
    )
    {
    }

    public function findByNameAndCategoryId(string $schemaName, string $categoryID,): ParsingSchema
    {
        $parsingSchemaData = ProductPropertyCollection::find()
            ->asArray()
            ->select(['parsingSchemas' => [
                '$mergeObjects' => [
                    [
                        '$arrayElemAt' => [
                            '$parsingSchemas',
                            [
                                '$indexOfArray' => [
                                    '$parsingSchemas',
                                    [
                                        '$eq' => [
                                            '$parsingSchemas.name',
                                            $schemaName
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            ]])
            ->where(['_id' => $categoryID])
            ->limit(1)
            ->one();
        return $this->objectMapper->map($parsingSchemaData['parsingSchemas'], ParsingSchema::class);
    }

    public function update(ParsingSchema $schema, string $categoryID): void
    {
        $data = $this->objectMapper->map($schema, []);
        ProductPropertyCollection::getCollection()->update(
            ['_id' => $categoryID],
            ["parsingSchemas.$[elem]" => $data],
            [
                'arrayFilters' => [
                    ["elem.name" => $data['name']]
                ]
            ]
        );
    }

    public function save(ParsingSchema $schema): void
    {
        $snapshot = $this->objectMapper->map($schema, SchemaSnapshot::class);
        $insertData = [
            'id' => $snapshot->id,
            'name'=>$snapshot->name,
            'start_with_row_num' => $snapshot->startWithRowNum,
        ];
        $this->upsertBuilder
            ->useActiveRecord(ParsingSchemaRecord::class)
            ->upsertManyRecords([$insertData]);
        $schemaId = ParsingSchemaRecord::getDb()->getLastInsertID();
        foreach ($snapshot->relationshipPairsSnapshots as $relationshipPairsSnapshot){
            $pairs[] = [
                'id' => $relationshipPairsSnapshot->id,
                'schema_id' => $schemaId,
                'property_id' => $relationshipPairsSnapshot->propertyId,
                'external_column_name' => $relationshipPairsSnapshot->externalColumnName
            ];
        }
        $this->upsertBuilder
            ->useActiveRecord(ParsingSchemaPropertiesRecord::class)
            ->upsertManyRecords($pairs);
    }
}