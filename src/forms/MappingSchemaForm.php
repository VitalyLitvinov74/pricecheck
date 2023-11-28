<?php

namespace app\forms;

use elisdn\compositeForm\CompositeForm;

/**
 * @property MappingSchemaBunchForm[] $bunches;
 */
class MappingSchemaForm extends CompositeForm
{
    public $name;
    public $bunches;

    public function __construct($config = [])
    {
        $this->bunches = [];
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            ['name', 'string', 'strict' => true]
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name'=>"Имя схемы"
        ];
    }

    protected function internalForms(): array
    {
        return ['bunches'];
    }
}