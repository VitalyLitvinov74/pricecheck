<?php

namespace app\records;

use yii\db\ActiveRecord;

class ParsingSchemaPropertiesRecord extends ActiveRecord
{
    public static function tableName():string
    {
        return 'parsing_schema_properties';
    }
}