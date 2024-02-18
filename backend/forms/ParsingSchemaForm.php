<?php

namespace app\forms;

use yii\base\Model;

class ParsingSchemaForm extends Model
{
    public $name;
    public $properties;
    public $productTypeId;

    public function rules(): array
    {
        return [
            ['name', 'string'],
            ['productTypeId', 'string'],
            ['map']
        ];
    }
}