<?php

namespace app\records\pg;

use app\modules\adminPanelSettings\presentation\records\AdminPanelColumnsSettingsRecord;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class PropertyRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return "properties";
    }

    public function getTableSettings(): ActiveQuery{
        return $this->hasMany(AdminPanelColumnsSettingsRecord::class, ['property_of_business_logic_entity_id'=>'id']);
    }
}