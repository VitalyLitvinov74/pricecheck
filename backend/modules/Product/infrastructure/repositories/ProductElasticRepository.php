<?php

namespace app\modules\Product\infrastructure\repositories;

use app\domain\Product\Persistence\Snapshots\ProductSnapshot;
use app\libs\ObjectMapper\ObjectMapper;
use app\modules\Product\domain\Product;
use app\records\elastic\ProductIndex;
use Doctrine\Common\Collections\ArrayCollection;
use Yii;

class ProductElasticRepository
{
    public function __construct(private ObjectMapper $objectMapper = new ObjectMapper())
    {
    }

    public function save(Product $product): void
    {
        $this->saveAll(new ArrayCollection([$product]));
    }

    /**
     * @param ArrayCollection<int, Product> $products
     * @return void
     */
    public function saveAll(ArrayCollection $products): void
    {
        $elasticData = [];
        foreach ($products as $product) {
            $snapshot = $this->objectMapper->map($product, ProductSnapshot::class);
            foreach ($snapshot->attributesSnapshots as $attributeSnapshot) {
                $elasticData[] =
                    [
                        'create' => [
                            '_index' => ProductIndex::index(),
                        ]
                    ];
                $elasticData[] = [
                    'property_id' => $attributeSnapshot->propertySnapshot->id,
                    'product_id' => $snapshot->id,
                    'attribute_value' => $attributeSnapshot->value,
                ];
            }
        }
        Yii::$app->elasticsearch
            ->createBulkCommand([
                'index' => ProductIndex::index(),
                'actions' => $elasticData
            ])
            ->execute();
    }
}