<?php

namespace app\domain\ManageParsingSchema\Persistence;

use app\collections\CategoryCollection;
use app\domain\ManageParsingSchema\ParsingSchema;
use app\domain\ManageParsingSchema\Persistence\Snapshots\SchemaSnapshot;
use app\libs\MongoUpsertBuilder;
use app\libs\ObjectMapper\ObjectMapper;

class ParsingSchemaRepository
{
    public function __construct(
        private ObjectMapper       $objectMapper = new ObjectMapper(),
        private MongoUpsertBuilder $upsertBuilder = new MongoUpsertBuilder()
    )
    {
    }

    public function save(ParsingSchema $schema): void
    {
        $data = $this->objectMapper->map($schema, []);
        $categoryId = $data['categoryId'];
        unset($data['categoryId']);
        $this->upsertBuilder
            ->useActiveRecord(CategoryCollection::class)
            ->upsertOneRecord(
                $data,
                ['_id' => $categoryId],
                ['relationshipPairs' => 'productPropertyName']
            );
    }

    private function savePairs(SchemaSnapshot $schemaSnapshot): array
    {
        $data = [];
        foreach ($schemaSnapshot->relationshipPairs as $relationshipPair) {
            $data[] = [
                'category_id' => $schemaSnapshot->categoryId,
                'external_field_name' => $relationshipPair->externalFieldName,
                'product_property_name' => $relationshipPair->productPropertyName
            ];
        }
        $this->upsertBuilder->useActiveRecord()->upsertManyRecords($data);
    }
}