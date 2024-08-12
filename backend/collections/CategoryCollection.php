<?php

namespace app\collections;

use yii\mongodb\ActiveRecord;

class CategoryCollection extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'categories';
    }
}