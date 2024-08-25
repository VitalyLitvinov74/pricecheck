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
            [['value'], 'required'],
            [['name', 'type', 'id'], 'string', 'strict' => true],
            ['id', 'required', 'when' => function ($model) {
                return empty($model->name);
            }],
            ['name', 'required', 'when' => function ($model) {
                return empty($model->id);
            }],
        ];
    }

    public function scenarios(): array
    {
        return [
            'create' => ['name', 'type'],
            'create-product' => ['id', 'name', 'value']
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