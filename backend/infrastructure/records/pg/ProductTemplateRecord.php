<?php

namespace app\infrastructure\records\pg;

use yii\db\ActiveRecord;

class ProductTemplateRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'product_templates';
    }
}