<?php

namespace app\records;


use yii\db\ActiveRecord;

class CategoryRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'categories';
    }
}