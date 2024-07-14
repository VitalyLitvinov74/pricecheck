<?php

namespace app\records;

use yii\mongodb\ActiveRecord;

class CategoriesCollection extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'categories';
    }
}