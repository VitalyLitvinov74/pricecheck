<?php

namespace app\modules\Product\infrastructure\records;

use yii\db\ActiveRecord;

class ProductAttributeRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'product_attributes';
    }
}