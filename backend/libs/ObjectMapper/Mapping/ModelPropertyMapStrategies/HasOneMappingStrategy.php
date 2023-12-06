<?php

namespace app\libs\ObjectMapper\Mapping\ModelPropertyMapStrategies;


use app\libs\ObjectMapper\Attributes\HasOneModel;
use app\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use app\libs\ObjectMapper\Mapping\MappingModes\MappingMode;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\ObjectMapper\ReflectionTrait;
use app\libs\LibsException;
use ReflectionProperty;

class HasOneMappingStrategy implements ModelPropertyMapStrategy
{
    use CheckingTrait;
    use ReflectionTrait;

    public function __construct(
        private HasOneModel $attributeInstance,
        private MappingMode $mappingMode
    ) {
    }

    /**
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
    ): void {
        $this->throwExceptionIfPropertyCannotBeNull($value, $modelReflectionProperty);
        if (is_null($value)) {
            $modelReflectionProperty->setValue($modelInstance, null);
            return;
        }
        $modelReflectionProperty->setValue(
            $modelInstance,
            $this->nestedObject(
                $value,
                $this->attributeInstance->nestedType
            )
        );
    }

    /**
     * @param object|array $from
     * @param string|array $to
     *
     * @return object|array
     */
    private function nestedObject(object|array $from, string|array $to): object|array
    {
        $nestedObjectMapper = new ObjectMapper();
        return $nestedObjectMapper->map($from, $to, true);
    }

    /**
     * @param object $modelInstance
     * @param ReflectionProperty $modelReflectionProperty
     *
     * @return mixed
     * @throws LibsException
     */
    public function extractModelProperty(
        object $modelInstance,
        ReflectionProperty $modelReflectionProperty,
    ): mixed {
        $modelPropertyValue = $modelReflectionProperty->getValue($modelInstance);

        $this->throwExceptionIfPropertyCannotBeNull($modelPropertyValue, $modelReflectionProperty);

        if (is_null($modelPropertyValue)) {
            return null;
        }

        if (is_object($modelPropertyValue) === false) {
            throw new ImpossibleIsNotMapping(
                sprintf(
                    'Свойство %s у модели %s не может быть null',
                    $modelReflectionProperty->getName(),
                    $modelReflectionProperty->getDeclaringClass()->getName()
                )
            );
        }

        if ($this->mappingMode === MappingMode::modelToArray) {
            return $this->nestedObject($modelPropertyValue, []);
        }

        $objectType = $this->defineTypeForMappingToObject();
        if ($this->mappingMode === MappingMode::modelToObject && $objectType !== null) {
            return $this->nestedObject(
                $modelPropertyValue,
                $objectType
            );
        }

        throw new ImpossibleIsNotMapping(
            sprintf(
                'Внутренне свойство %s н %s не возможно смаппить, атрибут %s не верно сконфигурирован',
                $modelReflectionProperty->getName(),
                $modelReflectionProperty->getDeclaringClass()->getName(),
                $this->attributeInstance::class
            )
        );
    }

    private function defineTypeForMappingToObject(): string|null
    {
        $domainModel = $this->getDomainModelInstance($this->attributeInstance->nestedType);
        if ($domainModel === null) {
            throw new LibsException(
                sprintf(
                    'Не возможно провести маппинг вложенной модели %s в объект, у модели не указан DomainModel',
                    $this->attributeInstance->nestedType,
                )
            );
        }
        return $domainModel->mapWith;
    }
}