<?php

namespace app\records;

use yii\mongodb\ActiveRecord;

class MappingSchemaRecord extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'mapping_schemas';
    }

    /**
     * @return array list of attribute names.
     */
    public function attributes(): array
    {
        return ['_id', 'name'];
    }
}