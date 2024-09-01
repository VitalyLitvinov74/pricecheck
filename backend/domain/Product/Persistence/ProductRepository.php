<?php

namespace app\domain\Product\Persistence;

use app\domain\Product\Models\Property;
use app\domain\Product\Persistence\Snapshots\ProductSnapshot;
use app\domain\Product\Product;
use app\exceptions\BaseException;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\ProductAttributesRecord;
use app\records\ProductPropertiesRecord;
use app\records\ProductsRecords;
use Doctrine\Common\Collections\ArrayCollection;

class ProductRepository
{
    private array $propertiesData;
    /** @var Property[]  */
    private array $properties;

    public function __construct(
        private ObjectMapper  $objectMapper = new ObjectMapper(),
        private UpsertBuilder $upsertBuilder = new UpsertBuilder()
    )
    {
        $this->propertiesData = [];
        $this->properties = [];
    }

    public function find(int $id): Product
    {
        $data = ProductsRecords::find()
            ->where(['id' => $id])
            ->with([
                'productAttributes'
            ])
            ->asArray()
            ->one();
        if ($data === null) {
            throw new BaseException(
                sprintf('не найден товар с id = %s', $id),
                404
            );
        }
        $data['available_properties'] = ProductPropertiesRecord::find()->asArray()->all();
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
        $this->saveAttributes($productsSnapshots);
    }

    /**
     * @param ProductSnapshot[] $productsSnapshots
     * @return void
     */
    private function saveAttributes(array $productsSnapshots): void
    {
        $insertData = [];
        foreach ($productsSnapshots as $productsSnapshot) {
            foreach ($productsSnapshot->attributesSnapshots as $attributeSnapshot) {
                $insertData[] = [
                    'product_id' => $productsSnapshot->id,
                    'id' => $attributeSnapshot->id,
                    'value' => $attributeSnapshot->value,
                    'property_id' => $attributeSnapshot->propertySnapshot->id,
                    'property_name' => $attributeSnapshot->propertySnapshot->name
                ];
            }
        }
        $this->upsertBuilder
            ->useActiveRecord(ProductAttributesRecord::class)
            ->upsertManyRecords($insertData);
    }

    /**
     * @param $id
     * @return Property
     * @throws BaseException
     */
    public function findPropertyById($id): Property
    {
        if ($this->propertiesData === []) {
            $this->propertiesData = ProductPropertiesRecord::find()->select(['id', 'name'])->asArray()->all();
        }
        foreach ($this->properties as $mappedPropertyId => $property) {
            if ((int) $mappedPropertyId === (int) $id) {
                return $property;
            }
        }
        foreach ($this->propertiesData as $item){
            if((int) $item['id'] === (int) $id){
                $property = $this->objectMapper->map($item, Property::class);
                $this->properties[$id] = $property;
                return $property;
            }
        }
        throw new BaseException('Не найдено свойство товара с id=%s', $id);
    }

    /**
     * @return Property[]
     */
    public function availableProperties(): array{
        if($this->propertiesData === []){
            $this->propertiesData = ProductPropertiesRecord::find()->select(['id', 'name'])->asArray()->all();
        }
        foreach ($this->propertiesData as $propertyItem){
            $this->properties[$propertyItem['id']] =  $this->objectMapper->map($propertyItem, Property::class);
        }
        return $this->properties;
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