<?php

namespace app\modules\Product\application\Parsing;

use app\modules\Product\domain\Parsing\Document;
use app\modules\Product\domain\Parsing\Models\ProductCard;
use app\modules\Product\infrastructure\repositories\Parsing\MappingSchemasRepository;

class ParsingService
{
    public function __construct(
        private MappingSchemasRepository $mappingSchemasRepository = new MappingSchemasRepository(),
    )
    {
    }

    /**
     * @param string $filePath
     * @param string $passedName
     * @param string $parsingSchemaId
     * @return ProductCard[]
     */
    public function parse(string $filePath, string $passedName, string $parsingSchemaId): array
    {
        $document = new Document($filePath, $passedName);
        $mappingSchema = $this->mappingSchemasRepository->findBy($parsingSchemaId);
        $cards = $document->parseUse($mappingSchema)->toArray();

    }
}