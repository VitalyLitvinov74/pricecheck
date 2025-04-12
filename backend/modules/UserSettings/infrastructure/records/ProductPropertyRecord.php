<?php

namespace app\modules\UserSettings\infrastructure\records;

use app\modules\UserSettings\domain\Models\EntityType;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ProductPropertyRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'properties';
    }

    public function getUserSettings(): ActiveQuery
    {
        return $this->hasMany(UserSettingsRecord::class, ['entity_id' => 'id'])
            ->andOnCondition(['entity_type' => EntityType::ProductProperty->value]);
    }
}