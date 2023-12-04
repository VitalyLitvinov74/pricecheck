<?php

namespace app\forms;

use yii\base\Model;

class ProductFieldForm extends Model
{
    public $name;
    public $type;

    public function rules(): array
    {
        return [
            [['name', 'type'], 'required'],
            [['name', 'type'], 'string', 'skipOnEmpty' => false, 'strict' => true]
        ];
    }

    public function formName(): string
    {
        return '';
    }
}