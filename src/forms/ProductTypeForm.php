<?php

namespace app\forms;

use elisdn\compositeForm\CompositeForm;

/**
 * @property ProductTypeForm[] $productTypeForms
 * @property ParsingMapForm[] $parsingMapForms
 */
class ProductTypeForm extends CompositeForm
{
    public $name;
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->productTypeForms = [];
        $this->parsingMapForms = [];
    }

    public function rules(): array
    {
        return [
            ['name', 'required']
        ];
    }

    protected function internalForms(): array
    {
        return ['productTypeForms', 'parsingMapForms'];
    }

    public function formName(): string
    {
        return '';
    }
}