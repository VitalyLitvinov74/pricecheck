<?php

namespace app\modules\Product\presentation\forms;

use app\forms\Scenarious;
use yii\base\Model;

class ProductPropertyForm extends Model
{
    public $id;
    public $name;
    public $type;

    public function rules(): array
    {
        return [
            [['name', 'type', 'id'], 'required'],
            [['name', 'type'], 'string', 'strict' => true],
            ['id', 'integer']
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::Default => ['name', 'type'],
            Scenarious::CreateProduct => ['id', 'name'],
            Scenarious::CreateParsingSchema => ['id'],
            Scenarious::UpdateParsingSchema => ['id'],
            Scenarious::RemoveProperty => ['id'],
            Scenarious::UpdateProductProperty => ['id', 'name', 'type'],
            Scenarious::UpdateProduct => ['id'],
            Scenarious::ChangeProductListSettings => ['id'],
            Scenarious::DisAttachSetting => ['id']

        ];
    }

    public function formName(): string
    {
        return '';
    }
}