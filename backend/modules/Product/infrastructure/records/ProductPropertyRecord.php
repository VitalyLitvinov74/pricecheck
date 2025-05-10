<?php

namespace app\modules\Product\infrastructure\records;

use app\modules\UserSettings\infrastructure\records\UserSettingsRecord;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ProductPropertyRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'properties';
    }

    public function getUserSettingsPayload(): ActiveQuery
    {
        return $this
            ->hasMany(UserSettingsRecord::class, ['id' => 'user_settings_id'])
            ->viaTable(ProductPropertyUserSettingType::tableName(), ['product_property_id' => 'id']);
    }
}