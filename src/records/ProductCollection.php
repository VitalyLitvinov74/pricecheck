<?php

namespace app\records;

use yii\mongodb\ActiveRecord;

class ProductCollection extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'products';
    }
}