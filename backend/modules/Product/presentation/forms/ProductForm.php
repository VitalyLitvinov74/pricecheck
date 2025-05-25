<?php

namespace app\modules\Product\presentation\forms;

use app\forms\Scenarious;
use app\modules\Product\application\DTOs\AttributeDTO;
use yii\base\Model;

class ProductForm extends Model
{
    public $attributes;
    public $id;

    /**
     * @var AttributeDTO[]
     */
    private array $attributeDTOs;

    public function rules(): array
    {
        return [
            [['attributes', 'id'], 'required'],
            ['attributes', 'validateAttributes', 'skipOnEmpty' => false],
            ['id', 'integer']
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::Default => ['attributes', 'id'],
            Scenarious::CreateProduct => ['attributes'],
            Scenarious::RemoveProduct => ['id'],
            Scenarious::UpdateProduct => ['id', 'attributes']
        ];
    }

    public function validateAttributes()
    {
        foreach ($this->attributes as $key => $attribute) {
            $form = new AttributeForm([
                'scenario' => $this->scenario
            ]);
            $form->load($attribute);
            if (!$form->validate()) {
                $this->addError("attributes/$key", $form->getErrors());
                continue;
            }
            $this->attributeDTOs[] = new AttributeDTO(
                $form->propertyId,
                $form->propertyName,
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
        return $this->attributeDTOs;
    }
}