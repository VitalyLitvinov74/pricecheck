<?php

namespace app\records;

use yii\mongodb\ActiveRecord;

class ProductRecord extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'products';
    }
}