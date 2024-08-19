<?php

namespace app\collections;

use yii\mongodb\ActiveRecord;

class ProductsCollecction extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'products';
    }
}