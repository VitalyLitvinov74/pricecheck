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

    public function getSettings(): ActiveQuery{
        return $this->hasMany(AdminPanelProductListSettingsRecord::class, ['property_id'=>'id']);
    }
}