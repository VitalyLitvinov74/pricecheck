<?php

namespace app\domain\Product\Persistance;

use app\collections\ProductsCollection;
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
        $result = ProductsCollection::getCollection()->update(
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
                ['upsert' => true]
            );
        }
        $command->executeBatch(ProductsCollection::collectionName());
    }

    /**
     * Сам метод это ACL
     * @param string $documentPath
     * @param string $categoryId
     * @param string $parsingSchemaName
     * @return ArrayCollection
     */
    public function loadFromDocument(string $documentPath, string $passedName, string $parsingSchemaId): ArrayCollection
    {
        $parseService = new DocumentsParseService();
        /** @var ProductCard[] $result */
        $result = $parseService->parse($documentPath, $passedName, $parsingSchemaId);
        $products = new ArrayCollection();
        foreach ($result as $productCard) {
            $productCardArray = $this->objectMapper->map($productCard, []);
            $product = $this->objectMapper->map( $productCardArray, Product::class);
            $products->add($product);
        }
        return $products;
    }
}