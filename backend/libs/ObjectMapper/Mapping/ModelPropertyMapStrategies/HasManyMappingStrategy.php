<?php

namespace app\libs\ObjectMapper\Mapping\ModelPropertyMapStrategies;

use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use app\libs\ObjectMapper\Mapping\MappingModes\MappingMode;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\ObjectMapper\ReflectionTrait;
use app\libs\LibsException;
use Doctrine\Common\Collections\ArrayCollection;
use ReflectionProperty;

class HasManyMappingStrategy implements ModelPropertyMapStrategy
{
    use CheckingTrait;
    use ReflectionTrait;

    public function __construct(
        private HasManyModels $attributeInstance,
        private MappingMode $mappingMode,
    ) {
    }

    /**
     * @param object $modelInstance
     * @param ReflectionProperty $modelReflectionProperty
     * @param mixed $value
     *
     * @return void
     * @throws ImpossibleIsNotMapping
     */
    public function hydrateModelProperty(
        object &$modelInstance,
        ReflectionProperty $modelReflectionProperty,
        mixed $value
    ): void {
        $this->throwExceptionIfPropertyCannotBeNull($value, $modelReflectionProperty);
        $nestedModels = [];
        foreach ($value as $nestedObject) {
            $nestedModels[] = $this->nestedObject($nestedObject, $this->attributeInstance->nestedType);
        }

        $modelReflectionProperty->setValue($modelInstance, new ArrayCollection($nestedModels));
    }

    /**
     * @param object|array $from
     * @param string|array $to
     *
     * @return object|array
     */
    private function nestedObject(object|array $from, string|array $to): object|array
    {
        $mapper = new ObjectMapper();
        return $mapper->map($from, $to, true);
    }

    /**
     * @param object $modelInstance
     * @param ReflectionProperty $modelReflectionProperty
     *
     * @return mixed
     * @throws ImpossibleIsNotMapping|LibsException
     */
    public function extractModelProperty(
        object $modelInstance,
        ReflectionProperty $modelReflectionProperty,
    ): mixed {
        $modelPropertyValue = $modelReflectionProperty->getValue($modelInstance);
        $this->throwExceptionIfPropertyCannotBeNull($modelPropertyValue, $modelReflectionProperty);

        $nestedObjects = [];

        $objectType = $this->defineTypeForMappingToObject();

        if ($this->mappingMode === MappingMode::modelToObject && $objectType === null) {
            throw new ImpossibleIsNotMapping(
                sprintf(
                    'Внутреннее свойство %s у %s не возможно смаппить, атрибут %s не верно сконфигурирован',
                    $modelReflectionProperty->getName(),
                    $modelReflectionProperty->getDeclaringClass()->getName(),
                    $this->attributeInstance::class
                )
            );
        }

        foreach ($modelPropertyValue as $nestedModel) {
            if ($this->mappingMode === MappingMode::modelToArray) {
                $nestedObjects[] = $this->nestedObject($nestedModel, []);
                continue;
            }
            if ($this->mappingMode === MappingMode::modelToObject) {
                $nestedObjects[] = $this->nestedObject(
                    $nestedModel,
                    $objectType
                );
            }
        }

        return $nestedObjects;
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