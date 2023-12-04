<?php

namespace app\forms;

use yii\base\Model;

class ProductFieldForm extends AbstractForm
{
    public $name;
    public $type;

    public static function staticRules(): array
    {
        return [
            [['name', 'type'], 'required'],
            [['name', 'type'], 'string', 'skipOnEmpty' => false, 'strict' => true]
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