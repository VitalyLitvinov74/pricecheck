<?php

namespace app\records;

use yii\mongodb\ActiveRecord;

class ProductCardsCollection extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'product_cards';
    }
}