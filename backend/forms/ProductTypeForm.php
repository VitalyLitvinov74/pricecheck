<?php
namespace app\forms;

use yii\base\Model;

class ProductTypeForm extends Model
{
    use NestedFormTrait;
    public $title;

    public $properties;

    /** @var CardFieldForm[] $cardFields */
    public $cardFields;

    public function init(): void
    {
        parent::init();
    }

    public function rules(): array
    {
        return [
            [['title', 'properties'], 'required'],
            ['title', 'string']
        ];
    }

    public function load($data, $formName = null): bool
    {
        $loaded =  parent::load($data, $formName);
        if(!$loaded){
            return false;
        }
        return $this->loadNestedForm(
            'properties',
            'cardFields',
            CardFieldForm::class
        );
    }

    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        $validated = parent::validate($attributeNames, $clearErrors);
        if(!$validated){
            return false;
        }
        return $this->validateNestedForm('properties','cardFields');
    }

    public function formName(): string
    {
        return '';
    }
}