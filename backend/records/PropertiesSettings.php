<?php

namespace app\records;

use yii\db\ActiveRecord;

class PropertiesSettings extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'properties_settings';
    }
}