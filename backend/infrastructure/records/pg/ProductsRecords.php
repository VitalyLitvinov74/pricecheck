<?php

namespace app\infrastructure\records\pg;

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

    public function getProductAttributes(): ActiveQuery{
        return $this->hasMany(ProductAttributesRecord::class, ['product_id'=>'id']);
    }
}