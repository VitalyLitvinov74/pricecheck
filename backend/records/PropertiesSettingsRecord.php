<?php

namespace app\records;

use yii\db\ActiveRecord;

class PropertiesSettingsRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'properties_settings';
    }
}