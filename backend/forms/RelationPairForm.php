<?php

namespace app\forms;

use yii\base\Model;

class RelationPairForm extends Model
{
    public $productPropertyId;
    public $externalFieldName;

    public function rules(): array
    {
        return [
            [['productPropertyId', 'externalFieldName'],'required'],
            [['productPropertyId', 'externalFieldName'], 'string']
        ];
    }

    public function formName(): string
    {
        return '';
    }
}