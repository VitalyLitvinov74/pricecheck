<?php

namespace app\modules\Product\infrastructure\records;

use yii\db\ActiveRecord;

class UserSettingRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'user_settings';
    }
}