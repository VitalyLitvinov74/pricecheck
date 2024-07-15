<?php

namespace app\domain\ManageParsingSchema\Persistence;

use app\domain\ManageParsingSchema\ParsingSchema;
use app\domain\ManageParsingSchema\Persistence\Snapshots\SchemaSnapshot;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use Yii;

class ParsingSchemaRepository
{
    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper(),
        private UpsertBuilder $upsertBuilder = new UpsertBuilder()
    )
    {
    }

    public function save(ParsingSchema $schema): void
    {
        $schemaSnapshot = $this->objectMapper->map($schema, SchemaSnapshot::class);

    }

    private function savePairs(SchemaSnapshot $schemaSnapshot): array{
        $data = [];
        foreach ($schemaSnapshot->relationshipPairs as $relationshipPair){
            $data[] = [
                'category_id' => $schemaSnapshot->categoryId,
                'external_field_name' => $relationshipPair->externalFieldName,
                'product_property_name' => $relationshipPair->productPropertyName
            ];
        }
        $this->upsertBuilder->useActiveRecord()->upsertManyRecords($data);
    }
}