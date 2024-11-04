<?php

namespace app\records;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class PropertyRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return "properties";
    }

    public function getSettings(): ActiveQuery{
        return $this->hasMany(PropertiesSettingsRecord::class, ['property_id'=>'id']);
    }
}