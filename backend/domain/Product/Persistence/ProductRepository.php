<?php

namespace app\domain\Product\Persistence;

use app\domain\Product\Persistence\Snapshots\ProductSnapshot;
use app\exceptions\BaseException;
use app\libs\LibsException;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\modules\Product\application\DocumentsParseService;
use app\modules\Product\domain\ParceDocument\Models\ProductCard;
use app\modules\Product\domain\ParceDocument\Persistance\Snapshots\DocumentSnapshot;
use app\modules\Product\domain\Product\Models\Attribute;
use app\modules\Product\domain\Product\Models\Property;
use app\modules\Product\domain\Product\Product;
use app\records\pg\ProductAttributesRecord;
use app\records\pg\ProductRecord;
use app\records\pg\PropertyRecord;
use Doctrine\Common\Collections\ArrayCollection;
use Throwable;
use Yii;
use yii\db\Exception;

class ProductRepository
{
    use ProductMappingSchema;

    private array $propertiesData;
    /** @var Property[] */
    private array $properties;

    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper(),
        private UpsertBuilder $upsertBuilder = new UpsertBuilder()
    )
    {
        $this->propertiesData = [];
        $this->properties = [];
    }

    public function find2(int $id): Product
    {
        $product = Yii::$app->cycle->orm($this->schemna())
            ->getRepository(Product::class)
            ->findByPK($id);

        return $product;
    }

    public function find(int $id): Product
    {
        $data = ProductRecord::find()
            ->where(['id' => $id])
            ->forProductDomain()
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
     * @throws LibsException
     */
    private function saveProducts(array $productsSnapshots): void
    {
        foreach ($productsSnapshots as $snapshot) {
            $this->upsertBuilder
                ->useActiveRecord(ProductRecord::class)
                ->upsertOneRecord(['id' => $snapshot->id]);
            if ($snapshot->id === null) {
                $snapshot->id = ProductRecord::getDb()->getLastInsertID();
            }
        }
        $this->saveAttributes($productsSnapshots);
    }

    /**
     * @param ProductSnapshot[] $productsSnapshots
     * @return void
     * @throws LibsException
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
            ->useUniqueKeys(['property_id', 'product_id'])
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
        ProductRecord::deleteAll(['id' => $id]);
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

    public function findAll(): ArrayCollection
    {
        $records = ProductRecord::find()
            ->with([
                'productAttributes',
                'productAttributes.property'
            ])
            ->asArray()
            ->all();
        $products = [];
        foreach ($records as $record) {
            $products[] = $this->objectMapper->map($record, Product::class);
        }
        return new ArrayCollection($products);
    }
}