<?php

namespace app\forms;

use yii\base\Model;

abstract class NestedForm extends Model
{
    abstract protected function nestedFormsMap(): array;

    private function loadNestedForm(string $whereToGetValues, string $formClass, array $classProperties = []): bool
    {
        if (is_null($this->$whereToGetValues)) {
            return false;
        }
        if (is_array($this->$whereToGetValues)) {
            $nestedForms = [];
            foreach ($this->$whereToGetValues as $propertyKey => $property) {
                /** @var Model $form */
                $form = new $formClass($classProperties);
                if (!$form->load($property)) {
                    return false;
                }
                $nestedForms[] = $form;
            }
            $this->$whereToGetValues = $nestedForms;
        } else {
            $form = new $formClass($classProperties);
            if (!$form->load($this->$whereToGetValues)) {
                return false;
            }
            $this->$whereToGetValues = $form;
        }


        return true;
    }

    private function validateNestedForm(string $propertyName): bool
    {
        $propertiesErrors = [];
        if (is_array($this->$propertyName)) {
            foreach ($this->$propertyName as $formNum => $form) {
                if ($form->validate() === false) {
                    foreach ($form->getErrors() as $errorName => $error) {
                        $propertiesErrors[$formNum][$errorName] = $error;
                    }
                }
            }
        } else {
            if ($this->$propertyName->validate() === false) {
                foreach ($this->$propertyName->getErrors() as $errorName => $error) {
                    $propertiesErrors[$errorName] = $error;
                }
            }
        }

        if ($propertiesErrors !== []) {
            $this->addError($propertyName, $propertiesErrors);
            return false;
        }

        return true;
    }

    /**
     * @param $attributeNames
     * @param $clearErrors
     * @return bool
     */
    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        $validated = parent::validate($attributeNames, $clearErrors);
        if (!$validated) {
            return false;
        }
        $isValid = true;
        foreach ($this->nestedFormsMap() as $propertyName => $nestedFormName) {
            if ($this->validateNestedForm($propertyName) === false) {
                $isValid = false;
            }
        }
        return $isValid;
    }

    public function load($data, $formName = null): bool
    {
        $loaded = parent::load($data, $formName);
        if (!$loaded) {
            return false;
        }
        $isLoad = true;
        foreach ($this->nestedFormsMap() as $property => $nestedData) {
            $nestedClassName = $nestedData;
            if(is_array($nestedData)){
                $nestedClassName = $nestedData['class'];
                unset($nestedData['class']);
                $classProperties =  $nestedData;
            }
            if(is_string($nestedData)){
                $nestedClassName = $nestedData;
                $classProperties = [];
            }
            $loadedNestedForm = $this->loadNestedForm($property, $nestedClassName, $classProperties);
            if ($loadedNestedForm === false) {
                $isLoad = false;
            }
        }
        return $isLoad;
    }
}