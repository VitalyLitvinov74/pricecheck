<?php

namespace app\modules\Product\infrastructure\records;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ProductRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'products';
    }

    public function getProductAttributes(): ActiveQuery
    {
        return $this->hasMany(ProductAttributeRecord::class, ['product_id' => 'id']);
    }
}