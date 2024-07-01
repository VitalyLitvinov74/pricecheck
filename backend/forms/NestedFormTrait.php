<?php

namespace app\forms;

use yii\base\Model;

trait NestedFormTrait
{
    private function loadNestedForm(string $whereToGetValues, string $whereToInsertValues, string $formClass): bool
    {
        $propertiesErrors = [];
        foreach ($this->$whereToGetValues as $propertyKey => $property) {
            /** @var Model $form */
            $form = new $formClass();
            if (!$form->load($property)) {
                foreach ($form->getErrors() as $errorName => $error) {
                    $propertiesErrors[$propertyKey][$errorName] = $error;
                }
            }
            $this->$whereToInsertValues[] = $form;
        }
        if ($propertiesErrors !== []) {
            $this->addError($whereToGetValues, $propertiesErrors);
            return false;
        }
        return true;
    }

    private function validateNestedForm(string $propertyForErrors, string $nestedForms): bool
    {
        $propertiesErrors = [];
        foreach ($this->$nestedForms as $formNum => $form) {
            if ($form->validate() === false) {
                foreach ($form->getErrors() as $errorName => $error) {
                    $propertiesErrors[$formNum][$errorName] = $error;
                }
            }
        }
        if ($propertiesErrors !== []) {
            $this->addError($propertyForErrors, $propertiesErrors);
            return false;
        }

        return true;
    }
}