<?php

namespace app\forms;

use app\libs\NestedForm;

class RelationPairForm extends NestedForm
{
    public $id;

    /** @var ProductPropertyForm */
    public $productProperty;
    public $externalFieldName;

    public function rules(): array
    {
        return [
            [['productProperty', 'externalFieldName', 'id'], 'required'],
            [['externalFieldName'], 'string'],

        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::UpdateParsingSchema => ['id', 'productProperty', 'externalFieldName'],
            Scenarious::CreateParsingSchema => ['productProperty', 'externalFieldName']
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
                'scenario' => $this->scenario
            ]
        ];
    }
}