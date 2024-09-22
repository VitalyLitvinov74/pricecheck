<?php

namespace app\records;

use yii\db\ActiveRecord;

class PropertiesRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return "properties";
    }
}