<?php

namespace app\modules\adminPanelSettings\presentation\records;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class AdminPanelColumnsSettingsRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'admin_panel_columns_settings';
    }

    public function getProductProperty(): ActiveQuery
    {
        return $this->hasOne(
            ProductPropertyRecord::class,
            ['id' => 'property_of_business_logic_entity_id']
        );
    }
}