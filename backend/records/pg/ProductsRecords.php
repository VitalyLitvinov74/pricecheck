<?php

namespace app\records\pg;

use app\records\pg\queries\ProductQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property ProductAttributesRecord $productAttributes
 */
class ProductsRecords extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'products';
    }

    public static function find(): ProductQuery
    {
        return new ProductQuery(get_called_class());
    }

    public function getProductAttributes(): ActiveQuery
    {
        return $this->hasMany(ProductAttributesRecord::class, ['product_id' => 'id']);
    }
}