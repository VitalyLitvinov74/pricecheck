<?php

namespace app\infrastructure\libs\ObjectMapper\Mapping\MappingModes;

use app\infrastructure\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use app\infrastructure\libs\ObjectMapper\ReflectionTrait;
use yii\helpers\ArrayHelper;

class ModelToArrayMode implements MappingModeStrategyInterface
{
    use ReflectionTrait;

    public function map(mixed $from, mixed &$to): void
    {
        if (!is_object($from)) {
            throw new ImpossibleIsNotMapping(
                'Не возможно произвести маппинг, поскольку мы должны мапить из модели в массив. Однако на вход мы получаем не модель'
            );
        }
        if (!is_array($to)) {
            throw new ImpossibleIsNotMapping(
                'Не возможно произвести маппинг, поскольку мы должны мапить из модели в массив. Однако на вход мы получаем не массив'
            );
        }
        $model = $from;
        $modelReflectionClass = $this->getReflectionClass($model);
        foreach ($modelReflectionClass->getProperties() as $modelReflectionProperty) {
            $attributeInstance = $this->extractAttributeInstance($modelReflectionProperty);

            if ($attributeInstance === null) {
                continue;
            }

            $objectKey = $attributeInstance->foreignKey(MappingMode::modelToArray);
            if ($objectKey === null) {
                continue; //значит не нужно мапить свойство моодели в свойство объекта
            }

            $propertyExtractStrategy = $this->defineStrategyWorkWithModelProperty(
                $attributeInstance,
                MappingMode::modelToArray
            );

            //Извлекаем данные из модели
            $value = $propertyExtractStrategy->extractModelProperty(
                $model,
                $modelReflectionProperty,
            );

            ArrayHelper::setValue($to, $objectKey, $value);
        }
    }
}