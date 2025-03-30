<?php

namespace app\presentation\forms;

use yii\base\Model;

class ProductTemplateForm extends Model
{
    public $productTemplateId;
    public $properties;

    public function rules(): array
    {
        return [];
    }
}