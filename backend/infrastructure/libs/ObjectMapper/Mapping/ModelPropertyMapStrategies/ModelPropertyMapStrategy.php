<?php

namespace app\infrastructure\libs\ObjectMapper\Mapping\ModelPropertyMapStrategies;

use app\infrastructure\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use ReflectionProperty;

interface ModelPropertyMapStrategy
{
    /**
     * Маппит данные в свойство модели
     *
     * @param object $modelInstance
     * @param ReflectionProperty $modelReflectionProperty
     * @param mixed $value
     *
     * @return void - изменяет объект model
     * @throws ImpossibleIsNotMapping
     */
    public function hydrateModelProperty(
        object &$modelInstance,
        ReflectionProperty $modelReflectionProperty,
        mixed $value
    ): void;


    /**
     * Получает данные из свойства модели.
     *
     * @param object $modelInstance
     * @param ReflectionProperty $modelReflectionProperty
     *
     * @return mixed
     */
    public function extractModelProperty(
        object $modelInstance,
        ReflectionProperty $modelReflectionProperty,
    ): mixed;
}