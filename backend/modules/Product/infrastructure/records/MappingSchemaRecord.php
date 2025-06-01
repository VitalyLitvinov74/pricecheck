<?php

namespace app\modules\Product\infrastructure\records;

use yii\db\ActiveRecord;

class MappingSchemaRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'parsing_schemas';
    }
}