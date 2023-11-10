<?php

namespace app\forms;

use elisdn\compositeForm\CompositeForm;
use yii\base\Model;

class MappingSchemaForm extends Model
{
    public $name;
    public $bunches;

    public function rules(): array
    {
        return [
            [['name', 'bunches'], 'required'],
            ['name', 'string', 'strict'],
            ['bunches', 'validateBunches']
        ];
    }

    public function validateBunches()
    {

    }
}