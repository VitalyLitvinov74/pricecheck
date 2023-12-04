<?php

namespace app\forms;

use yii\base\Model;

class ParsingMapForm extends Model
{
    public $name;

    public function rules(): array
    {
        return [
            [['name'],'required']
        ];
    }

    public function formName(): string
    {
        return '';
    }
}