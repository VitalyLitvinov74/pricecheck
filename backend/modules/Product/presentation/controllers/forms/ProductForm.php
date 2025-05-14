<?php

namespace app\modules\Product\presentation\controllers\forms;

use app\forms\ProductAttributeForm;
use app\forms\Scenarious;
use yii\base\Model;

class ProductForm extends Model
{
    /** @var ProductAttributeForm[] */
    public $productAttributes;
    public $id;

    public function rules(): array
    {
        return [
            [['productAttributes', 'id'], 'required'],
            ['id', 'integer']
        ];
    }
    public function scenarios(): array
    {
        return [
            Scenarious::CreateProduct => ['productAttributes'],
            Scenarious::RemoveProduct => ['id'],
            Scenarious::UpdateProduct => ['id', 'productAttributes']
        ];
    }

    protected function nestedFormsMap(): array
    {
        return [
            'productAttributes' => [
                'class' => ProductAttributeForm::class,
                'scenario' => $this->scenario
            ]
        ];
    }

    public function formName(): string
    {
        return '';
    }
}