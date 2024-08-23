<?php
namespace app\forms;

class ProductsTypesForm extends NestedForm
{
    public $title;

    /** @var ProductTypeForm[] $properties */
    public $properties;
    private const properties = 'properties';

    public function rules(): array
    {
        return [
            [[self::properties], 'required', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }

    public function formName(): string
    {
        return '';
    }

    protected function nestedFormsMap(): array
    {
        return [
            self::properties => ProductTypeForm::class
        ];
    }
}