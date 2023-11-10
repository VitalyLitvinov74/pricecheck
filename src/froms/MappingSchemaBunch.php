<?php

namespace app\forms;

use yii\base\Model;

class MappingSchemaBunch extends Model
{
    public $productPropertyName;
    public $fileColumnName;
    
    public function rules(): array
    {
        return [
            [['productPropertyName', 'fileColumnName'], 'required']
        ];
    }
}