<?php

namespace app\modules\adminPanelSettings\presentation\records;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class AdminPanelEntitiesRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'admin_panel_entities';
    }

    public function getColumnsSettings(): ActiveQuery
    {
        return $this->hasMany(AdminPanelColumnsSettingsRecord::class, ['admin_panel_entity_id'=>'id']);
    }
}