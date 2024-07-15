<?php

namespace app\domain\ManageParsingSchema\Persistence;

use app\domain\ManageParsingSchema\ParsingSchema;
use app\libs\ObjectMapper\ObjectMapper;
use Yii;

class ParsingSchemaRepository
{
    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper()
    )
    {
    }

    public function save(ParsingSchema $schema): void
    {
        $schemaData = $this->objectMapper->map($schema, []);
        $tt = '';
    }
}