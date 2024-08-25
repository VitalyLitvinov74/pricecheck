<?php

namespace app\forms;

use yii\base\Model;

class ProductPropertyForm extends Model
{
    public $name;
    public $type;
    public static function staticRules(): array
    {
        return [
            [['name'], 'required'],
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