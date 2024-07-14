<?php
namespace app\forms;

class ProductTypeForm extends NestedForm
{
    public $title;

    /** @var CardFieldForm[] $properties */
    public $properties;
    private const properties = 'properties';

    public function rules(): array
    {
        return [
            [['title', self::properties], 'required', 'skipOnEmpty' => false, 'skipOnError' => false],
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
            self::properties => CardFieldForm::class
        ];
    }
}