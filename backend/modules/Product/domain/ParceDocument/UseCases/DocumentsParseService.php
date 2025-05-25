<?php

namespace app\modules\Product\domain\ParceDocument\UseCases;

use app\domain\Product\UseCase\ProductsService;
use app\modules\Product\domain\ParceDocument\Document;
use app\modules\Product\domain\ParceDocument\Models\ProductCard;
use app\modules\Product\domain\ParceDocument\Persistance\MappingSchemasRepository;
use Doctrine\Common\Collections\ArrayCollection;

class DocumentsParseService
{
    public function __construct(
        private MappingSchemasRepository $mappingSchemasRepository = new MappingSchemasRepository(),
        private ProductsService $productsService = new ProductsService()
    ) { }

    /**
     * @param string $filePath
     * @param string $passedName
     * @param string $parsingSchemaId
     * @return ArrayCollection<int, ProductCard>
     */
    public function parse(string $filePath, string $passedName, string $parsingSchemaId): Document
    {
        $document = new Document($filePath, $passedName);
        $mappingSchema = $this->mappingSchemasRepository->findBy($parsingSchemaId);
        $document->parseUse($mappingSchema);
        return $document;
    }
}