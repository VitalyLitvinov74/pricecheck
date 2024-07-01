<?php

namespace app\forms;

use yii\base\Model;

class ParsingSchemaForm extends Model
{
    use NestedFormTrait;
    public $name;
    public $map;
    public $productTypeId;
    public $relationsPairs;

    public function rules(): array
    {
        return [
            [['name', 'productTypeId', 'map'], 'required'],
            ['name', 'string'],
            ['productTypeId', 'string']
        ];
    }

    public function load($data, $formName = null): bool
    {
        if(!parent::load($data, $formName)){
            return false;
        }
        return $this->loadNestedForm(
            'map',
            'relationsPairs',
            RelationPairForm::class
        );
    }

    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        if(!parent::validate($attributeNames, $clearErrors)){
            return false;
        }
        return $this->validateNestedForm('map', 'relationsPairs');
    }

    public function formName(): string
    {
        return '';
    }
}