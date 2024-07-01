<?php

namespace app\forms;

use yii\base\Model;

class RelationPairForm extends Model
{
    public $productPropertyName;
    public $externalFieldName;

    public function rules(): array
    {
        return [
            [['productPropertyName', 'externalFieldName'],'required'],
            [['productPropertyName', 'externalFieldName'], 'string']
        ];
    }

    public function formName(): string
    {
        return '';
    }
}