<?php

namespace app\records;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class PropertiesRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return "properties";
    }

    public function getSettings(): ActiveQuery{
        return $this->hasMany(PropertiesSettings::class, ['property_id'=>'id']);
    }
}