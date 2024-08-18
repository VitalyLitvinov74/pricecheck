<?php

namespace app\domain\Product\Persistance;

use app\domain\ParseDocument\Models\ProductCard;
use app\domain\ParseDocument\UseCases\DocumentsParseService;
use app\domain\Product\Models\Property;
use app\domain\Product\Models\ValueType;
use app\domain\Product\Product;
use app\libs\ObjectMapper\ObjectMapper;
use Doctrine\Common\Collections\ArrayCollection;

class ProductRepository
{
    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper(),
        private CategoriesRepository $categoriesRepository = new CategoriesRepository()
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
        /** @var ProductCard[] $result */
        $result = $service->parse($documentPath,'', $categoryId, $parsingSchemaName);
        $products = new ArrayCollection();
        foreach ($result as $productCard){
            $productCardArray = $this->objectMapper->map($productCard, []);
            $category = $this->categoriesRepository->find($productCardArray['categoryId']);
            $product = new Product($category);//
            foreach ($productCardArray['properties'] as $property){
                $product->add(new Property($property['name'], $property['value'], ''));
            }
            $products->add($product);
        }
        return $products;
    }
}