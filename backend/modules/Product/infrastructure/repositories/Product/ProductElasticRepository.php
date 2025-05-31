<?php

namespace app\modules\Product\infrastructure\repositories\Product;

use app\domain\Product\Persistence\Snapshots\ProductSnapshot;
use app\modules\Product\infrastructure\records\ProductAttributeRecord;
use app\records\elastic\ProductIndex;
use Yii;

class ProductElasticRepository
{
    public function __construct()
    {
    }

    public function revalidate(int $productId): void
    {
        $this->revalidateOf([$productId]);
    }

    /**
     * @param int[] $productIds
     * @return void
     */
    public function revalidateOf(array $productIds): void
    {
        $attributes = ProductAttributeRecord::find()
            ->select([
                'id',
                'product_id',
                'property_id',
                'attribute_value' => 'value',
            ])
            ->where(['product_id' => $productIds])
            ->asArray()
            ->all();
        $elasticData = [];
        foreach ($attributes as $attribute) {
            $elasticData[] = [
                'create' => [
                    '_index' => ProductIndex::index(),
                ]
            ];
            $elasticData[] = $attribute;
        }
        Yii::$app->elasticsearch
            ->createBulkCommand([
                'index' => ProductIndex::index(),
                'actions' => $elasticData
            ])
            ->execute();
    }
}