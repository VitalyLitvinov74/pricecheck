<?php

namespace app\modules\Product\presentation\controllers\forms;

use app\forms\ProductAttributeForm;
use app\forms\Scenarious;
use app\modules\Product\application\DTOs\AttributeDTO;
use yii\base\Model;

class ProductForm extends Model
{
    /** @var ProductAttributeForm[] */
    public $productAttributes;
    public $id;
    private array $attributeDTOs;

    public function rules(): array
    {
        return [
            [['productAttributes', 'id'], 'required'],
            ['productAttributes','validateProductAttributes'],
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

    public function validateProductAttributes()
    {
        if($this->productAttributes === []){
            $this->addError();
        }
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

    /**
     * @return AttributeDTO[]
     */
    public function attributeDTOs(): array
    {

    }
}