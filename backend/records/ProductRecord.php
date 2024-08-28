<?php

namespace app\records;

use yii\db\ActiveRecord;

class ProductRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'products';
    }
}