<?php

namespace app\forms;

use yii\base\Model;

class MappingSchemaBunchForm extends Model
{
    public $productPropertyName;
    public $fileColumnName;
    
    public function rules(): array
    {
        return [
            [['productPropertyName', 'fileColumnName'], 'required']
        ];
    }

    public function formName(): string
    {
        return '';
    }
}