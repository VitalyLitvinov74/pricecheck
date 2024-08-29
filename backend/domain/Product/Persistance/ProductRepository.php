<?php

namespace app\domain\Product\Persistance;

use app\collections\ProductsCollection;
use app\domain\Product\Models\Category;
use app\domain\Product\Persistance\Snapshots\ProductSnapshot;
use app\domain\Product\Product;
use app\exceptions\BaseException;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\ProductsRecords;
use app\records\ProductPropertiesRecord;
use Doctrine\Common\Collections\ArrayCollection;

class ProductRepository
{
    public function __construct(
        private ObjectMapper  $objectMapper = new ObjectMapper(),
        private UpsertBuilder $upsertBuilder = new UpsertBuilder()
    )
    {
    }

    public function find(int $id): Product
    {
        $data = ProductsRecords::find()
            ->where(['id' => $id])
            ->with([
                'properties'
            ])
            ->asArray()
            ->one();
        if ($data === null) {
            throw new BaseException(
                sprintf('не найден товар с id = %s', $id),
                404
            );
        }
        $data['available'] = ProductPropertiesRecord::find()->asArray()->all();
        return $this->objectMapper->map($data, Product::class);
    }

    /**
     * @param ArrayCollection $products
     * @return void
     */
    public function saveAll(ArrayCollection $products): void
    {
        $productsSnapshots = [];
        foreach ($products as $product) {
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
        foreach ($productsSnapshots as $snapshot) {
            $this->upsertBuilder
                ->useActiveRecord(ProductsRecords::class)
                ->upsertOneRecord(['id' => $snapshot->id]);
            $id = ProductsRecords::getDb()->getLastInsertID();
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
        foreach ($productsSnapshots as $productsSnapshot) {
            foreach ($productsSnapshot->properties as $propertySnapshot) {
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