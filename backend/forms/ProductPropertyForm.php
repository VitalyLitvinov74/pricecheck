<?php

namespace app\forms;

use yii\base\Model;

class ProductPropertyForm extends Model
{
    public $id;
    public $name;
    public $type;

    public function rules(): array
    {
        return [
            [['name', 'type', 'id'], 'required'],
            [['name', 'type'], 'string', 'strict' => true],
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::CreateProduct->value => ['id']
        ];
    }

    public function formName(): string
    {
        return '';
    }
}