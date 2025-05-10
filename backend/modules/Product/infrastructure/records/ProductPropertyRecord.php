<?php

namespace app\modules\Product\infrastructure\records;

use yii\db\ActiveRecord;

class ProductPropertyRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'properties';
    }
}