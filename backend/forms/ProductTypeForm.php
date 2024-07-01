<?php
namespace app\forms;

use yii\base\DynamicModel;

class ProductTypeForm
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
}