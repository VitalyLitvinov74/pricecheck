<?php

namespace app\records\pg;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ParsingSchemaPropertiesRecord extends ActiveRecord
{
    public static function tableName():string
    {
        return 'parsing_schema_properties';
    }

    public function getProperty(): ActiveQuery{
        return $this->hasOne(PropertyRecord::class,['id' => 'property_id']);
    }
}