<?php

namespace app\domain\Product\Persistance;

use app\domain\ParseDocument\UseCases\DocumentsParseService;
use app\domain\Product\Product;
use app\libs\ObjectMapper\ObjectMapper;
use Doctrine\Common\Collections\ArrayCollection;

class ProductRepository
{
    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper()
    )
    {
    }

    /**
     * @param Product[]|ArrayCollection<int, Product> $products
     * @return void
     */
    public function saveAll(array|ArrayCollection $products): void
    {


    }

    /**
     * Сам метод это ACL
     * @param string $documentPath
     * @param string $categoryId
     * @param string $parsingSchemaName
     * @return ArrayCollection
     */
    public function getFromDocument(string $documentPath, string $categoryId, string $parsingSchemaName): ArrayCollection{
        $service = new DocumentsParseService();
        $result = $service->parse($documentPath,'', $categoryId, $parsingSchemaName);
        $products = new ArrayCollection();
        foreach ($result as $productCards){
            $product = new Product($productsCard->categoryId);
            //
            //добавить свойства.
            //
            $products->add($product);
        }
        return $products;
    }
}