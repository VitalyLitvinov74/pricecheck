<?php

namespace app\modules\TableSettings\presentation\records;

use app\records\pg\AdminPanelTableSettingsRecord;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class AdminPanelEntities extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'admin_panel_entities';
    }

    public function getTableSettings(): ActiveQuery
    {
        return $this->hasMany(AdminPanelTableSettingsRecord::class, ['admin_panel_entity_id'=>'id']);
    }
}