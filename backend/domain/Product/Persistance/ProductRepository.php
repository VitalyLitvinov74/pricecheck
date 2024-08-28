<?php

namespace app\domain\Product\Persistance;

use app\collections\ProductsCollection;
use app\domain\Product\Models\Category;
use app\domain\Product\Persistance\Snapshots\ProductSnapshot;
use app\domain\Product\Persistance\Snapshots\PropertySnapshot;
use app\domain\Product\Product;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\ProductRecord;
use Doctrine\Common\Collections\ArrayCollection;
use Yii;
use yii\mongodb\Exception;

class ProductRepository
{
    public function __construct(
        private ObjectMapper       $objectMapper = new ObjectMapper(),
        private PropertyRepository $categoriesRepository = new PropertyRepository(),
        private UpsertBuilder      $upsertBuilder = new UpsertBuilder()
    )
    {
    }

    public function find(string $id): Product
    {
        //сложить все свойства в property
    }

    /**
     * @param ArrayCollection $products
     * @return void
     */
    public function saveAll(ArrayCollection $products): void
    {
        $productsSnapshots = [];
        foreach ($products as $product){
            $productsSnapshots[] = $this->objectMapper->map($product, ProductSnapshot::class);
        }
        $this->saveProducts($productsSnapshots);
    }

    /**
     * @param ProductSnapshot[] $productsSnapshots
     * @return void
     */
    private function saveProducts(array $productsSnapshots): void
    {
        foreach ($productsSnapshots as $snapshot){
            $this->upsertBuilder
                ->useActiveRecord(ProductRecord::class)
                ->upsertOneRecord(['id' => $snapshot->id]);
            $id = ProductRecord::getDb()->getLastInsertID();
            $snapshot->id = $id;
        }
        $this->saveProperties($productsSnapshots);
    }

    /**
     * @param ProductSnapshot[] $productsSnapshots
     * @return void
     */
    private function saveProperties(array $productsSnapshots): void
    {
        $insertData = [];
        foreach ($productsSnapshots as $productsSnapshot){
            foreach ($productsSnapshot->properties as $propertySnapshot){
                $insertData[] = [
                    'product_id' => $productsSnapshot->id,
                    'property_id' => $propertySnapshot->propertyId,
                    'property_name' => $propertySnapshot->propertyName,
                    'property_value' => $propertySnapshot->propertyValue
                ];
            }
        }
        $this->upsertBuilder->upsertManyRecords($insertData);
    }



//    /**
//     * Сам метод это ACL
//     * @param string $documentPath
//     * @param string $categoryId
//     * @param string $parsingSchemaName
//     * @return ArrayCollection
//     */
//    public function loadFromDocument(string $documentPath, string $passedName, string $parsingSchemaId): ArrayCollection
//    {
//        $parseService = new DocumentsParseService();
//        /** @var ProductCard[] $result */
//        $result = $parseService->parse($documentPath, $passedName, $parsingSchemaId);
//        $products = new ArrayCollection();
//        foreach ($result as $productCard) {
//            $productCardArray = $this->objectMapper->map($productCard, []);
//            $product = $this->objectMapper->map( $productCardArray, Product::class);
//            $products->add($product);
//        }
//        return $products;
//    }
}