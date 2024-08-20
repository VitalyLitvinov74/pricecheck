<?php

namespace app\forms;

use yii\base\Model;

class CardFieldForm extends Model
{
    public $name;
    public $value;

    public static function staticRules(): array
    {
        return [
            [['name', 'value'], 'required'],
            [['name'], 'string', 'skipOnEmpty' => false, 'strict' => true]
        ];
    }

    public function rules(): array
    {
        return self::staticRules();
    }

    public function formName(): string
    {
        return '';
    }
}