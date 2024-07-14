<?php

namespace app\domain\ParseDocument\UseCases;

use app\domain\ParseDocument\Document;
use app\domain\ParseDocument\Persistance\MappingSchemasRepository;
use app\domain\ParseDocument\Persistance\ProductCardsRepository;

class DocumentsParseService
{
    public function __construct(
        private MappingSchemasRepository $mappingSchemasRepository = new MappingSchemasRepository(),
        private ProductCardsRepository $DocumentRepository = new ProductCardsRepository()
    ) { }

    public function parse(string $filePath, $filePassedName, string $categoryId, string $parsingMap): void
    {
        $document = new Document($filePath, $filePassedName);
        $mappingSchema = $this->mappingSchemasRepository->findBy($categoryId, $parsingMap);
        $document->parseUse($mappingSchema);
        $this->DocumentRepository->save($document);
    }
}