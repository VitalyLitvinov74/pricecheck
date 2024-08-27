<?php

namespace app\collections;

use yii\mongodb\ActiveRecord;

class ParsingSchemas extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'parsingSchemas';
    }
}