<?php

namespace app\records\pg;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ProductAttributesRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'product_attributes';
    }

    public function getProperty(): ActiveQuery
    {
        return $this->hasOne(PropertyRecord::class, ['id' => 'property_id']);
    }
}