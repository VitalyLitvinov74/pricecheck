<?php

namespace app\infrastructure\libs\ObjectMapper\Mapping\MappingModes;

use app\infrastructure\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use app\infrastructure\libs\ObjectMapper\ReflectionTrait;

class ModelToObjectMode implements MappingModeStrategyInterface
{
    use ReflectionTrait;

    /**
     * @param mixed $from
     * @param mixed $to
     *
     * @return void
     * @throws ImpossibleIsNotMapping
     */
    public function map(mixed $from, mixed &$to): void
    {
        if (!is_object($from)) {
            throw new ImpossibleIsNotMapping(
                'Не возможно произвести маппинг, поскольку мы должны мапить из модели в объект. Однако на вход мы получаем не модель'
            );
        }
        if (!is_object($to)) {
            throw new ImpossibleIsNotMapping(
                'Не возможно произвести маппинг, поскольку мы должны мапить из модели в объект. Однако на вход мы получаем не объект'
            );
        }
        $model = $from;
        $object = $to;
        $modelReflectionClass = $this->getReflectionClass($model);
        $objectReflectionClass = $this->getReflectionClass($object);
        foreach ($modelReflectionClass->getProperties() as $modelReflectionProperty) {
            $attributeInstance = $this->extractAttributeInstance($modelReflectionProperty);

            if ($attributeInstance === null) {
                continue;
            }

            $objectKey = $attributeInstance->foreignKey(MappingMode::modelToObject);
            if ($objectKey === null) {
                continue; //значит не нужно мапить свойство моодели в свойство объекта
            }

            $propertyExtractStrategy = $this->defineStrategyWorkWithModelProperty(
                $attributeInstance,
                MappingMode::modelToObject
            );

            //Извлекаем данные из модели
            $value = $propertyExtractStrategy->extractModelProperty(
                $model,
                $modelReflectionProperty,
            );

            //мапим данные в сторонний объект
            $this->hydratePropertyValue(
                $objectReflectionClass,
                $object,
                $objectKey,
                $value
            );
        }
    }

}