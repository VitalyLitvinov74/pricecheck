<?php

namespace app\domain\ManageParsingSchema\Persistence;

use app\collections\ProductPropertyCollection;
use app\domain\ManageParsingSchema\ParsingSchema;
use app\libs\ObjectMapper\ObjectMapper;
use MongoDB\BSON\ObjectId;

class ParsingSchemaRepository
{
    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper()
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

    public function push(ParsingSchema $schema, string $categoryID): void
    {
        $data = $this->objectMapper->map($schema, []);
        ProductPropertyCollection::getCollection()->update(
            ['_id' => new ObjectId($categoryID)],
            ['$push' => ["parsingSchemas" => $data]],
        );
    }
}