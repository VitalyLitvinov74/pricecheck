<?php

namespace app\records;

use yii\db\ActiveRecord;

class ProductProperties extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'product_properties';
    }
}