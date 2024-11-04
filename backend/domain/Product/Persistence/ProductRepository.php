<?php

namespace app\domain\Product\Persistence;

use app\domain\ParseDocument\Models\ProductCard;
use app\domain\ParseDocument\Persistance\Snapshots\DocumentSnapshot;
use app\domain\ParseDocument\UseCases\DocumentsParseService;
use app\domain\Product\Models\Attribute;
use app\domain\Product\Models\Property;
use app\domain\Product\Persistence\Snapshots\ProductSnapshot;
use app\domain\Product\Product;
use app\exceptions\BaseException;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\ProductAttributesRecord;
use app\records\ProductsRecords;
use app\records\PropertyRecord;
use Doctrine\Common\Collections\ArrayCollection;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\Query;

class ProductRepository
{
    private array $propertiesData;
    /** @var Property[] */
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
                'productAttributes' => function (Query $query) {
                    $query->emulateExecution();
                },
                'productAttributes.property' => function (Query $query) {
                    $query->emulateExecution();
                }
            ])
            ->asArray()
            ->one();
        if ($data === null) {
            throw new BaseException(
                sprintf('не найден товар с id = %s', $id),
                404
            );
        }
        $data['available_properties'] = PropertyRecord::find()->asArray()->all();
        return $this->objectMapper->map($data, Product::class);
    }

    /**
     * @param ArrayCollection $products
     * @return void
     * @throws Throwable
     * @throws Exception
     */
    public function saveAll(ArrayCollection $products): void
    {
        $trx = Yii::$app->db->beginTransaction();
        try {
            $productsSnapshots = [];
            foreach ($products as $product) {
                $productsSnapshots[] = $this->objectMapper->map($product, ProductSnapshot::class);
            }
            $this->saveProducts($productsSnapshots);
            $trx->commit();
        } catch (Throwable $throwable) {
            $trx->rollBack();
            throw $throwable;
        }
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
            if ($snapshot->id === null) {
                $snapshot->id = ProductsRecords::getDb()->getLastInsertID();
            }
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
        $this->upsertBuilder
            ->useActiveRecord(ProductAttributesRecord::class)
            ->removeEverythingExcept(['product_id', 'property_id'], $insertData, 'product_id');
    }

    /**
     * @param $id
     * @return Property
     * @throws BaseException
     */
    public function findPropertyById($id): Property
    {
        if ($this->propertiesData === []) {
            $this->propertiesData = PropertyRecord::find()->select(['id', 'name'])->asArray()->all();
        }
        foreach ($this->properties as $mappedPropertyId => $property) {
            if ((int)$mappedPropertyId === (int)$id) {
                return $property;
            }
        }
        foreach ($this->propertiesData as $item) {
            if ((int)$item['id'] === (int)$id) {
                $property = $this->objectMapper->map($item, Property::class);
                $this->properties[$id] = $property;
                return $property;
            }
        }
        throw new BaseException(sprintf('Не найдено свойство товара с id=%s', $id));
    }

    /**
     * @return Property[]
     */
    public function availableProperties(): array
    {
        if ($this->propertiesData === []) {
            $this->propertiesData = PropertyRecord::find()->select(['id', 'name'])->asArray()->all();
        }
        foreach ($this->propertiesData as $propertyItem) {
            $this->properties[$propertyItem['id']] = $this->objectMapper->map($propertyItem, Property::class);
        }
        return $this->properties;
    }


    /**
     * Сам метод это ACL
     * @param string $documentPath
     * @param string $passedName
     * @param string $parsingSchemaId
     * @return ArrayCollection
     * @throws BaseException
     */
    public function loadFromDocument(string $documentPath, string $passedName, string $parsingSchemaId): ArrayCollection
    {
        $parseService = new DocumentsParseService();
        /** @var ProductCard[] $result */
        $result = $parseService->parse($documentPath, $passedName, $parsingSchemaId);
        $products = new ArrayCollection();
        $documentSnapshot = $this->objectMapper->map($result, DocumentSnapshot::class);
        foreach ($documentSnapshot->productsCardsSnapshots as $productCardSnapshot) {
            $product = new Product();
            foreach ($productCardSnapshot->productCardPropertiesSnapshots as $propertySnapshot) {
                $product->attachWith(
                    new Attribute(
                        $this->findPropertyById($propertySnapshot->id),
                        $propertySnapshot->value
                    )
                );
            }
            $products->add($product);
        }
        return $products;
    }

    public function remove(int $id): void
    {
        ProductsRecords::deleteAll(['id' => $id]);
    }

    /**
     * @param Product $product
     * @return void
     * @throws Exception
     * @throws Throwable
     */
    public function save(Product $product): void
    {
        $this->saveAll(new ArrayCollection([$product]));
    }
}