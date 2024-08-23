<?php

namespace app\collections;

use yii\mongodb\ActiveRecord;

class ProductPropertyCollection extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'productsTypes';
    }
}