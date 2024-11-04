<?php

namespace app\records;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class PropertiesSettingsRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'properties_settings';
    }

    public function getProperty(): ActiveQuery{
        return $this->hasOne(PropertyRecord::class, ['id'=>'property_id']);
    }
}