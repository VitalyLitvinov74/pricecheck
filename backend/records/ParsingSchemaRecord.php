<?php

namespace app\records;

use yii\db\ActiveRecord;

class ParsingSchemaRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'parsing_schemas';
    }

    public function getParsingSchemaProperties()
    {
        return $this->hasMany(ParsingSchemaPropertiesRecord::class, ['schema_id'=>'id']);
    }
}