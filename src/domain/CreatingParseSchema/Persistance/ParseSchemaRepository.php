<?php

namespace app\domain\CreatingParseSchema\Persistence;

use app\domain\CreatingParseSchema\ParseSchema;
use app\domain\CreatingParseSchema\Snapshots\ParseSchemaSnapshot;
use app\libs\ObjectMapper\ObjectMapper;

class ParseSchemaRepository
{
    private ObjectMapper $objectMapper;

    public function __construct()
    {
        $this->objectMapper = new ObjectMapper();
    }

    public function findById()
    {

    }

    public function save(ParseSchema $parseSchema): void{
        $data = $this->objectMapper->map($parseSchema, ParseSchemaSnapshot::class);

    }
}