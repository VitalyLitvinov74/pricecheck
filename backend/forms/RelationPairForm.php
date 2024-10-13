<?php

namespace app\forms;

class RelationPairForm extends NestedForm
{
    /** @var ProductPropertyForm */
    public $productProperty;
    public $externalFieldName;

    public function rules(): array
    {
        return [
            [['productProperty', 'externalFieldName'], 'required'],
            [['externalFieldName'], 'string'],

        ];
    }

    public function formName(): string
    {
        return '';
    }

    protected function nestedFormsMap(): array
    {
        return [
            'productProperty' => [
                'class' => ProductPropertyForm::class,
                'scenario' => Scenarious::CreateParsingSchema
            ]
        ];
    }
}