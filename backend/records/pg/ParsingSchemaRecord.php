<?php

namespace app\records\pg;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property ParsingSchemaPropertiesRecord parsingSchemaProperties
 */
class ParsingSchemaRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'parsing_schemas';
    }

    public function getParsingSchemaProperties(): ActiveQuery
    {
        return $this->hasMany(ParsingSchemaPropertiesRecord::class, ['schema_id'=>'id']);
    }
}