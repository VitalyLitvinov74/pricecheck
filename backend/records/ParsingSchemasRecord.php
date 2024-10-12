<?php

namespace app\records;

use yii\db\ActiveRecord;

/**
 * @property ParsingSchemaPropertiesRecord parsingSchemaProperties
 */
class ParsingSchemasRecord extends ActiveRecord
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