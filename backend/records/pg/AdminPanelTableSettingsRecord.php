<?php

namespace app\records\pg;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class AdminPanelTableSettingsRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'admin_panel_tables_settings';
    }

    public function getProperty(): ActiveQuery{
        return $this->hasOne(PropertyRecord::class, ['id'=>'property_of_business_logic_entity_id']);
    }
}