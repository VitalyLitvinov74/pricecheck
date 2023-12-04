<?php

namespace app\forms;

use yii\base\Model;

abstract class AbstractForm extends Model
{
    protected function mergeRules(Model $model, array ...$rulesList): array
    {
        $totalRules = [];
        $totalRules = array_merge($totalRules, $model->rules());
        foreach ($rulesList as $rule) {
            $totalRules = array_merge($totalRules, [$rule]);
        }
        return $totalRules;
    }

    public function rules(): array
    {
        return static::staticRules();
    }

    abstract public static function staticRules(): array;

    public function formName(): string
    {
        return '';
    }
}