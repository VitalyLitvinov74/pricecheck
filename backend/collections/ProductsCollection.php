<?php

namespace app\collections;

use yii\mongodb\ActiveRecord;

class ProductsCollection extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'products';
    }
}