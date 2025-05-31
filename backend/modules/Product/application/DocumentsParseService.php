<?php

namespace app\modules\Product\application;

use app\modules\Product\domain\ParceDocument\Document;
use app\modules\Product\domain\ParceDocument\Models\ProductCard;
use app\modules\Product\domain\ParceDocument\Persistance\MappingSchemasRepository;

class DocumentsParseService
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