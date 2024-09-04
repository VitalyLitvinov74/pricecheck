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
            ['id', 'integer']
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::Default->value => ['name', 'type'],
            Scenarious::CreateProduct->value => ['id'],
            Scenarious::CreateParsingSchema->value => ['id'],

        ];
    }

    public function formName(): string
    {
        return '';
    }
}