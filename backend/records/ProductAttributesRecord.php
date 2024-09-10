<?php

namespace app\records;

use yii\db\ActiveRecord;

class ProductAttributesRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'product_attributes';
    }
}