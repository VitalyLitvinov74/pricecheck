<?php

namespace app\infrastructure\records\pg;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class AdminPanelProductListSettingsRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'admin_panel_product_list_settings';
    }

    public function getProperty(): ActiveQuery{
        return $this->hasOne(PropertyRecord::class, ['id'=>'property_id']);
    }
}