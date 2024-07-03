<?php
namespace app\forms;

class ProductTypeForm extends NestedForm
{
    public $title;

    /** @var CardFieldForm[] $properties */
    public $properties;

    public function rules(): array
    {
        return [
            [['title', 'properties'], 'required', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['title', 'string'],
        ];
    }

    public function formName(): string
    {
        return '';
    }

    protected function nestedFormsMap(): array
    {
        return [
            'properties' => CardFieldForm::class
        ];
    }
}