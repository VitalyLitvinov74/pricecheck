<?php

namespace app\records;

use yii\db\ActiveRecord;

class ProductsRecords extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'products';
    }
}