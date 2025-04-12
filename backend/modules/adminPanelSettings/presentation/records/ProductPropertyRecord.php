<?php

namespace app\modules\adminPanelSettings\presentation\records;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ProductPropertyRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'properties';
    }
}