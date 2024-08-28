<?php

namespace app\records;

use yii\db\ActiveRecord;

class CategoryFieldsRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'category_fields';
    }
}