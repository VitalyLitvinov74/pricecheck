<?php

namespace app\modules\UserSettings\infrastructure\records;

use yii\db\ActiveRecord;

class UserSettingsRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'user_settings';
    }
}