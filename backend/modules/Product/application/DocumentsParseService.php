<?php

namespace app\modules\Product\application;

use app\modules\Product\domain\ParceDocument\Document;
use app\modules\Product\domain\ParceDocument\Persistance\MappingSchemasRepository;

class DocumentsParseService
{
    public function __construct(
        private MappingSchemasRepository $mappingSchemasRepository,
        private ProductService $productsService,
    ) { }

    /**
     * @param string $filePath
     * @param string $passedName
     * @param string $parsingSchemaId
     * @return Document
     */
    public function parse(string $filePath, string $passedName, string $parsingSchemaId): Document
    {
        $document = new Document($filePath, $passedName);
        $mappingSchema = $this->mappingSchemasRepository->findBy($parsingSchemaId);
        $document->parseUse($mappingSchema);
        return $document;
    }
}