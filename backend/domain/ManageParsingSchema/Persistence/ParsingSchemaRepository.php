<?php

namespace app\domain\ManageParsingSchema\Persistence;

use app\collections\CategoryCollection;
use app\domain\ManageParsingSchema\ParsingSchema;
use app\domain\ManageParsingSchema\Persistence\Snapshots\SchemaSnapshot;
use app\libs\MongoUpsertBuilder;
use app\libs\MysqlUpsertBuilder;
use app\libs\ObjectMapper\ObjectMapper;

class ParsingSchemaRepository
{
    public function __construct(
        private ObjectMapper       $objectMapper = new ObjectMapper(),
        private MysqlUpsertBuilder $upsertBuilder = new MysqlUpsertBuilder()
    )
    {
    }

    public function save(ParsingSchema $schema): void
    {
        $data = $this->objectMapper->map($schema, []);
        unset($data['categoryId']);
        $this->upsertBuilder
            ->useActiveRecord(CategoryCollection::class)
            ->upsertOneRecord(
                ['parsingSchemas' => [$data]],
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