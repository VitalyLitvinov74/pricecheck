<?php

namespace app\infrastructure\libs\ObjectMapper\Mapping\ModelPropertyMapStrategies;

use app\infrastructure\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use ReflectionProperty;

trait CheckingTrait
{
    /**
     * @param $value
     * @param ReflectionProperty $modelReflectionProperty
     *
     * @return void
     * @throws ImpossibleIsNotMapping
     */
    private function throwExceptionIfPropertyCannotBeNull($value, ReflectionProperty $modelReflectionProperty): void
    {
        if (is_null($value) && $modelReflectionProperty->getType()->allowsNull() === false) {
            throw new ImpossibleIsNotMapping(
                sprintf(
                    'Свойство %s в модели %s не может иметь тип null',
                    $modelReflectionProperty->getName(),
                    $modelReflectionProperty->getDeclaringClass()->getName()
                )
            );
        }
    }
}