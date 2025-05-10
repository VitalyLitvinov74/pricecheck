<?php

namespace app\modules\Product\infrastructure\records;

use yii\db\ActiveRecord;

class ProductPropertyUserSettingType extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'product_property_user_setting';
    }
}