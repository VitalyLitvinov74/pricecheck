<?php

namespace app\modules\TableSettings\presentation\records;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class AdminPanelTableSettingsRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'admin_panel_tables_settings';
    }

//    public function getEntity(): ActiveQuery
//    {
////        return $this->hasOne()
//    }
}