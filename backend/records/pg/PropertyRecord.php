<?php

namespace app\records\pg;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class PropertyRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return "properties";
    }

    public function getColumnsSettings(): ActiveQuery{
        return $this->hasMany(AdminPanelTableSettingsRecord::class, ['property_of_business_logic_entity_id'=>'id']);
    }
}