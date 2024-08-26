<?php

namespace app\domain\Product\Persistance;

use app\collections\ProductsCollecction;
use app\domain\ParseDocument\Models\ProductCard;
use app\domain\ParseDocument\UseCases\DocumentsParseService;
use app\domain\Product\Models\Category;
use app\domain\Product\Models\Property;
use app\domain\Product\Product;
use app\libs\ObjectMapper\ObjectMapper;
use Doctrine\Common\Collections\ArrayCollection;
use Yii;
use yii\mongodb\Exception;

class ProductRepository
{
    public function __construct(
        private ObjectMapper       $objectMapper = new ObjectMapper(),
        private PropertyRepository $categoriesRepository = new PropertyRepository()
    )
    {
    }

    public function find(string $id): Product
    {
        //сложить все свойства в property
    }

    public function save(Product $product): string
    {
        $insertData = $this->objectMapper->map($product, []);
        $result = ProductsCollecction::getCollection()->update(
            ['_id' => $insertData['_id']],
            $insertData,
            ['upsert' => true]);
        return $result;
    }

    /**
     * @param Product[]|ArrayCollection<int, Product> $products
     * @return void
     * @throws Exception
     */
    public function saveAll(array|ArrayCollection $products): void
    {
        $command = Yii::$app->mongodb->createCommand();
        foreach ($products as $product) {
            $data = $this->objectMapper->map($product, []);
            $command->addUpdate(
                ['_id' => $data['_id']],
                $data,
                ['upsert'=>true]
            );
        }
        $command->executeBatch(ProductsCollecction::collectionName());
    }

    /**
     * Сам метод это ACL
     * @param string $documentPath
     * @param string $categoryId
     * @param string $parsingSchemaName
     * @return ArrayCollection
     */
    public function getFromDocument(string $documentPath, string $categoryId, string $parsingSchemaName): ArrayCollection
    {
        $service = new DocumentsParseService();
        /** @var ProductCard[] $result */
        $result = $service->parse($documentPath, '', $parsingSchemaName);
        $products = new ArrayCollection();
        $categoriesList = [];
        foreach ($result as $productCard) {
            $productCardArray = $this->objectMapper->map($productCard, []);
            $categoryId = $productCardArray['categoryId'];
            if (array_key_exists($categoryId, $categoriesList)) {
                $category = $categoriesList[$categoryId];
            } else {
                $category = $this->categoriesRepository->findBy($categoryId);
                $categoriesList[$productCardArray['categoryId']] = $category;
            }
            $product = new Product($category);//
            foreach ($productCardArray['properties'] as $property) {
                $product->add(new Property($property['name'], $property['value'], ''));
            }
            $products->add($product);
        }
        return $products;
    }
}