<?php

namespace app\domain\ManageParsingSchema\Persistence;

use app\collections\CategoryCollection;
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
        $parsingSchemaData = CategoryCollection::find()
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
                    [
                        'categoryId' => $categoryID
                    ]
                ]
            ]])
            ->where(['_id' => $categoryID])
            ->limit(1)
            ->one();
        return $this->objectMapper->map($parsingSchemaData['parsingSchemas'], ParsingSchema::class);
    }

    public function update(ParsingSchema $schema): void
    {
        $data = $this->objectMapper->map($schema, []);
        $categoryId = $data['categoryId'];
        unset($data['categoryId']);
        CategoryCollection::getCollection()->update(
            ['_id' => $categoryId],
            ["parsingSchemas.$[elem]" => $data],
            [
                'arrayFilters' => [
                    ["elem.name" => $data['name']]
                ]
            ]
        );
    }

    public function push(ParsingSchema $schema): void
    {
        $data = $this->objectMapper->map($schema, []);
        $categoryId = $data['categoryId'];
        unset($data['categoryId']);
        CategoryCollection::getCollection()->update(
            ['_id' => new ObjectId($categoryId)],
            ['$push' => ["parsingSchemas" => $data]],
        );
    }
}