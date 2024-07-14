<?php

namespace app\domain\ParseDocument\UseCases;

use app\domain\ParseDocument\Document;
use app\domain\ParseDocument\Persistance\MappingSchemasRepository;
use app\domain\ParseDocument\Persistance\ProductCardsRepository;

class DocumentsParseService
{
    public function __construct(
        private MappingSchemasRepository $mappingSchemasRepository = new MappingSchemasRepository(),
        private ProductCardsRepository $productCardsRepository = new ProductCardsRepository()
    ) { }

    public function parse(string $documentPath, string $categoryId, string $parsingMap): void
    {
        $document = new Document($documentPath);
        $mappingSchema = $this->mappingSchemasRepository->findBy($categoryId, $parsingMap);
        $productCards = $document->parseUse($mappingSchema);
        $this->productCardsRepository->save($productCards);
    }
}