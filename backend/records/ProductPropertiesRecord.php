<?php

namespace app\records;

use yii\db\ActiveRecord;

class ProductPropertiesRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return "properties";
    }
}