<?php
namespace app\presentation\forms;

use app\libs\NestedForm;

class ProductsPropertiesForm extends NestedForm
{
    public $title;

    /** @var ProductPropertyForm[] $properties */
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
            self::properties => ProductPropertyForm::class
        ];
    }
}