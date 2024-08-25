<?php

namespace app\forms;

use yii\base\Model;

class ProductPropertyForm extends Model
{
    public $id;
    public $name;
    public $type;
    public $value;
    public static function staticRules(): array
    {
        return [
            [['name', 'id', 'value'], 'required'],
            [['name', 'type', 'id'], 'string', 'skipOnEmpty' => false, 'strict' => true]
        ];
    }

    public function scenarios(): array
    {
        return [
            'create' => ['name', 'type'],
            'create-product' => ['id', 'value']
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