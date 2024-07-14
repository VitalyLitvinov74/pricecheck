<?php

namespace app\domain\ManageParsingSchema\Persistence;

use app\domain\ManageParsingSchema\ParsingSchema;
use app\libs\ObjectMapper\ObjectMapper;
use app\records\CategoriesCollection;

class ParsingSchemaRepository
{
    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper()
    )
    {
    }

    public function save(ParsingSchema $schema): void
    {
        $schemaRecord = $this->objectMapper->map($schema, []);
        CategoriesCollection::getCollection() // подумать
            ->update(['_id'=>$schemaRecord['categoryId']], $schemaRecord, ['upsert' => true]);
    }
}