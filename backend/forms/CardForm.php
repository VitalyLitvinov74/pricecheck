<?php

namespace app\forms;

use elisdn\compositeForm\CompositeForm;
use yii\base\DynamicModel;

class CardForm extends CompositeForm
{
    public $title;

    /** @var CardFieldForm[] $properties */
    public $properties;

    public function init(): void
    {
        parent::init();
    }

    public function rules(): array
    {
        return [
            ['title', 'required'],
        ];
    }

    public function formName(): string
    {
        return '';
    }

    public function load($data, $formName = null): bool
    {
        $properties = [];
        if (isset($data['properties'])) {
            foreach ($data['properties'] as $property) {
                $properties[] = new CardFieldForm();
            }
            DynamicModel::loadMultiple($properties, $data['properties']);
        }
        $this->properties = $properties;
        return parent::load($data, $formName);
    }

    protected function internalForms(): array
    {
        return ['properties'];
    }
}