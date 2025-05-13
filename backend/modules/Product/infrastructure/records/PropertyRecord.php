<?php

namespace app\modules\Product\infrastructure\records;

use yii\db\ActiveRecord;

class PropertyRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'properties';
    }
}