<?php

namespace app\libs\ObjectMapper;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\HasOneModel;
use app\libs\ObjectMapper\Attributes\Property;
use app\libs\ObjectMapper\Attributes\PropertyAttribute;
use app\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use app\libs\ObjectMapper\Mapping\MappingModes\MappingMode;
use app\libs\ObjectMapper\Mapping\ModelPropertyMapStrategies\HasManyMappingStrategy;
use app\libs\ObjectMapper\Mapping\ModelPropertyMapStrategies\HasOneMappingStrategy;
use app\libs\ObjectMapper\Mapping\ModelPropertyMapStrategies\ModelPropertyMapStrategy;
use app\libs\ObjectMapper\Mapping\ModelPropertyMapStrategies\PropertyMappingStrategy;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * @template T
 */
trait ReflectionTrait
{
    /**
     * @param ReflectionProperty $reflectionProperty
     * @param string $attributeClassName
     *
     * @psalm-param T $attributeClassName
     * @return T[]
     */
    public function getAttributesInstances(
        ReflectionProperty $reflectionProperty,
        string $attributeClassName
    ): array {
        $reflectionAttributes = $reflectionProperty->getAttributes(
            $attributeClassName,
            ReflectionAttribute::IS_INSTANCEOF
        );
        $instances = [];
        foreach ($reflectionAttributes as $reflectionAttribute) {
            $instance = $reflectionAttribute->newInstance();
            $instances[] = $instance;
        }
        return $instances;
    }

    private function getDomainModelInstance(string $className): DomainModel|null
    {
        $class = $this->getReflectionClass($className);
        $attributes = $class->getAttributes(
            DomainModel::class,
            ReflectionAttribute::IS_INSTANCEOF
        );
        $instances = [];
        foreach ($attributes as $reflectionAttribute) {
            $instance = $reflectionAttribute->newInstance();
            $instances[] = $instance;
        }
        if ($instances === []) {
            return null;
        }
        return $instances[0];
    }

    /**
     * @param object|string $target
     *
     * @return ReflectionClass
     * @throws ImpossibleIsNotMapping
     */
    private function getReflectionClass(object|string $target): ReflectionClass
    {
        $className = is_object($target) ? get_class($target) : $target;
        static $reflectionClassMap = [];
        if (isset($reflectionClassMap[$className])) {
            return $reflectionClassMap[$className];
        }
        try {
            $reflectionClass = new ReflectionClass($className);
        } catch (ReflectionException $exception) {
            throw new ImpossibleIsNotMapping(
                sprintf('Класс %s не существует', $target)
            );
        }
        $reflectionClassMap[$className] = $reflectionClass;
        return $reflectionClass;
    }

    /**
     * @param ReflectionProperty $reflectionProperty
     *
     * @return PropertyAttribute|null
     * @throws ImpossibleIsNotMapping
     */
    private function extractAttributeInstance(ReflectionProperty $reflectionProperty): PropertyAttribute|null
    {
        $availableAttributes = $reflectionProperty->getAttributes(
            PropertyAttribute::class,
            ReflectionAttribute::IS_INSTANCEOF
        );
        if (empty($availableAttributes)) {
            return null;
        }
        if (count($availableAttributes) > 1) {
            throw new ImpossibleIsNotMapping(
                sprintf(
                    'На свойстве (property) %s доменной модели не может быть больше одного аттрибута %s',
                    $reflectionProperty->getName(),
                    $reflectionProperty->getDeclaringClass()->getName()
                )
            );
        }
        return $availableAttributes[0]->newInstance();
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param object $classInstance
     * @param string $propertyName
     *
     * @return mixed
     */
    private function extractPropertyValue(
        ReflectionClass $reflectionClass,
        object $classInstance,
        string $propertyName
    ): mixed {
        if ($reflectionClass->hasProperty($propertyName)) {
            $reflectionProperty = $reflectionClass
                ->getProperty($propertyName);

            $propertyValue = $reflectionProperty->getValue($classInstance);
        } else {
            $propertyValue = $classInstance->$propertyName;
        }
        return $propertyValue;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param object $classInstance
     * @param string $propertyName
     * @param mixed $value
     *
     * @return void
     */
    private function hydratePropertyValue(
        ReflectionClass $reflectionClass,
        object &$classInstance,
        string $propertyName,
        mixed $value
    ): void {
        if ($reflectionClass->hasProperty($propertyName)) {
            $reflectionProperty = $reflectionClass
                ->getProperty($propertyName);

            $reflectionProperty->setValue($classInstance, $value);
        } else {
            $classInstance->$propertyName = $value;
        }
    }

    /**
     * @param PropertyAttribute $attribute - атрибут настроек маппинга
     * @param MappingMode $mappingMode - в основном нужен для верного мапинга модели в массив и из вне
     *
     * @return ModelPropertyMapStrategy - стратегия работы со свойством модели
     */
    private function defineStrategyWorkWithModelProperty(
        PropertyAttribute $attribute,
        MappingMode $mappingMode = MappingMode::objectToModel,
    ): ModelPropertyMapStrategy {
        if ($attribute instanceof HasOneModel) {
            return new HasOneMappingStrategy($attribute, $mappingMode);
        }
        if ($attribute instanceof HasManyModels) {
            return new HasManyMappingStrategy($attribute, $mappingMode);
        }
        /** @var Property $attribute */
        return new PropertyMappingStrategy($attribute);
    }
}