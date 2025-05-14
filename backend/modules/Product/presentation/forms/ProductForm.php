<?php

namespace app\modules\Product\presentation\forms;

use app\forms\Scenarious;
use app\modules\Product\application\DTOs\AttributeDTO;
use yii\base\Model;

class ProductForm extends Model
{
    public $productAttributes;
    public $id;

    /**
     * @var AttributeDTO[]
     */
    private array $attributeDTOs;

    public function rules(): array
    {
        return [
            [['productAttributes', 'id'], 'required'],
            ['productAttributes', 'validateProductAttributes'],
            ['id', 'integer']
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::Default => ['productAttributes', 'id'],
            Scenarious::CreateProduct => ['productAttributes'],
            Scenarious::RemoveProduct => ['id'],
            Scenarious::UpdateProduct => ['id', 'productAttributes']
        ];
    }

    public function validateProductAttributes()
    {
        foreach ($this->productAttributes as $key => $attribute) {
            $form = new ProductAttributeForm([
                'scenario' => $this->scenario
            ]);
            $form->load($attribute);
            if (!$form->validate()) {
                $this->addError("productAttributes/$key", $form->getErrors());
                continue;
            }
            $this->attributeDTOs[] = new AttributeDTO(
                $form->propertyForm->id,
                $form->propertyForm->name,
                $form->value,
                $form->id
            );
        }
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
        return $this->attributeDTOs();
    }
}