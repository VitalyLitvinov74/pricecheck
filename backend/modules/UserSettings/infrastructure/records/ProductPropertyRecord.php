<?php

namespace app\modules\UserSettings\infrastructure\records;

use yii\db\ActiveRecord;

class ProductPropertyRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'properties';
    }
}