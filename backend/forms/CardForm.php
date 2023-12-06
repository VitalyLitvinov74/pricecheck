<?php

namespace app\forms;

use elisdn\compositeForm\CompositeForm;
use yii\base\DynamicModel;

class CardForm extends CompositeForm
{
    public $name;

    /** @var CardFieldForm[] $fields */
    public $fields;

    public function init(): void
    {
        parent::init();
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
        ];
    }

    public function formName(): string
    {
        return '';
    }

    public function load($data, $formName = null): bool
    {
        $fields = [];
        if (isset($data['fields'])) {
            foreach ($data['fields'] as $field) {
                $fields[] = new CardFieldForm();
            }
            DynamicModel::loadMultiple($fields, $data['fields']);
        }
        $this->fields = $fields;
        return parent::load($data, $formName);
    }

    protected function internalForms(): array
    {
        return ['fields'];
    }
}