<?php

namespace app\domain\ParseDocument\UseCases;

use app\domain\ParseDocument\Document;
use app\domain\ParseDocument\Models\ProductCard;
use app\domain\ParseDocument\Persistance\MappingSchemasRepository;
use app\domain\Product\UseCase\ProductsService;
use Doctrine\Common\Collections\ArrayCollection;

class DocumentsParseService
{
    public function __construct(
        private MappingSchemasRepository $mappingSchemasRepository = new MappingSchemasRepository(),
        private ProductsService $productsService = new ProductsService()
    ) { }

    /**
     * @param string $filePath
     * @param $filePassedName
     * @param string $categoryId
     * @param string $parsingMap
     * @return ArrayCollection<int, ProductCard>
     */
    public function parse(string $filePath, $filePassedName, string $categoryId, string $parsingMap): ArrayCollection
    {
        $document = new Document($filePath, $filePassedName);
        $mappingSchema = $this->mappingSchemasRepository->findBy($categoryId, $parsingMap);
        return $document->parseUse($mappingSchema);
    }
}