<?php

namespace app\modules\pbx\libs\ObjectMapper;

use app\modules\pbx\libs\ObjectMapper\Attributes\DomainModel;
use app\modules\pbx\libs\ObjectMapper\Attributes\HasManyModels;
use app\modules\pbx\libs\ObjectMapper\Attributes\HasOneModel;
use app\modules\pbx\libs\ObjectMapper\Attributes\Property;
use app\modules\pbx\PbxException;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use Throwable;

/**
 * @template T
 */
class ObjectsMapper
{
    public function __construct()
    {
    }

    /**
     * @param string $modelClass
     * @param object|null $dto
     * @return T
     * @throws PbxException
     */
    public function mapDtoToModel(string $modelClass, object|null $dto)
    {
        try {
            $reflector = $this->getReflectionClass($modelClass);
            $model = $reflector->newInstanceWithoutConstructor();
            $modelProperties = $this->getReflectionClass($model)->getProperties();
            foreach ($modelProperties as $modelProperty) {
                $this->mapProperties($model, $dto, $modelProperty);
                $this->mapNestedHasOne($model, $dto, $modelProperty);
                $this->mapNestedHasMany($model, $dto, $modelProperty);
            }
            return $model;
        } catch (Throwable $throwable) {
            throw new PbxException($throwable->getMessage(), $throwable->getCode(), $throwable);
        }
    }

    /**
     * @throws ReflectionException
     */
    private function getReflectionClass(object|string $target): ReflectionClass
    {
        static $reflectionClassMap = [];
        $className = is_object($target) ? get_class($target) : $target;
        if (!isset($reflectionClassMap[$className])) {
            $reflectionClassMap[$className] = new ReflectionClass($className);
        }
        return $reflectionClassMap[$className];
    }

    private function mapProperties(object &$object, object $dto, ReflectionProperty $reflectionProperty): void
    {
        $attributeInstance = $this->attributeInstance($reflectionProperty, Property::class);
        if (is_null($attributeInstance)) {
            return;
        }
        $dtoPropertyName = $attributeInstance->mapWithDtoProperty;
        try {
            $modelValue = $dto->$dtoPropertyName;
        } catch (Exception $e) {
            throw new DtoPropertyNotFound(
                $dtoPropertyName,
                $object::class,
                $reflectionProperty->getName()
            );
        }
        if ($attributeInstance->typecast) { //это класс Enum
            $enum = $attributeInstance->typecast::from($modelValue);
            $reflectionProperty->setValue($object, $enum);
            return;
        }
        if ($attributeInstance->toCollection) {//это массив который нужно преобразовать в коллекцию
            $reflectionProperty->setValue(
                $object,
                new ArrayCollection($modelValue)
            );
            return;
        }
        $reflectionProperty->setValue($object, $modelValue);
    }

    /**
     * @param ReflectionProperty $property
     * @param string $attributeName
     * @psalm-param class-string<T> $attributeName
     * @return T|null
     */
    private function attributeInstance(ReflectionProperty $property, string $attributeName): object|null
    {
        if (empty($property->getAttributes($attributeName))) {
            return null;
        }
        return $property->getAttributes($attributeName)[0]->newInstance();
    }

    private function mapNestedHasOne(object &$model, object $dto, ReflectionProperty $modelProperty): void
    {
        $attribute = $this->attributeInstance($modelProperty, HasOneModel::class);
        if (is_null($attribute)) {
            return;
        }
        $dtoPropertyName = $attribute->dtoProperty;
        try {
            $dtoPropertyValue = $dto->$dtoPropertyName;
        } catch (Exception $exception) {
            throw new DtoPropertyNotFound(
                $dtoPropertyName,
                $model::class,
                $modelProperty->getName()
            );
        }
        if ($dtoPropertyValue === null) {
            $modelProperty->setValue($model, null);
            return;
        }
        $propertyType = $modelProperty->getType();
        $nestedObject = $this->mapDtoToModel($propertyType->getName(), $dtoPropertyValue);
        $modelProperty->setValue($model, $nestedObject);
    }

    private function mapNestedHasMany(object &$object, object $dto, ReflectionProperty $objectProperty): void
    {
        $attribute = $this->attributeInstance($objectProperty, HasManyModels::class);
        if (is_null($attribute)) {
            return;
        }
        $dtoPropertyName = $attribute->dtoProperty;
        $nestedModels = [];
        try{
            $dtoProperty = $dto->$dtoPropertyName;
        }catch (Throwable $throwable){
            throw new DtoPropertyNotFound(
                $dtoPropertyName,
                $object::class,
                $objectProperty->getName()
            );
        }

        foreach ($dtoProperty as $nestedDto) {
            $nestedModels[] = $this->mapDtoToModel($attribute->nestedModelTypes, $nestedDto);
        }
        $objectProperty->setValue($object, new ArrayCollection($nestedModels));
    }

    private function mapHasOneToDto(
        object $model,
        object &$dto,
        ReflectionProperty $modelReflectionProperty,
        ReflectionProperty $dtoReflectionProperty
    ): void {
        $attribute = $this->attributeInstance($modelReflectionProperty, HasOneModel::class);
        if (is_null($attribute) or $attribute->dtoProperty !== $dtoReflectionProperty->getName()) {
            return;
        }
        $dtoReflectionProperty->setValue(
            $dto,
            $this->mapModelToDto(
                $modelReflectionProperty->getValue($model)
            )
        );
    }

    /**
     * @param object|null $domainModel
     * @return object|null
     * @throws PbxException
     */
    public function mapModelToDto(object|null $domainModel): object|null
    {
        try {
            if ($domainModel === null) {
                return null;
            }
            $domainModelReflector = $this->getReflectionClass($domainModel);
            $attributesDomainModels = $domainModelReflector->getAttributes(DomainModel::class);
            if (empty($attributesDomainModels)) {
                throw new DomainModelAttributeNotFound($domainModel::class);
            }
            /** @var DomainModel $attributeDomainModel */
            $attributeDomainModel = $attributesDomainModels[0]->newInstance();
            $dtoReflector = $this->getReflectionClass($attributeDomainModel->mappedWithDto);
            $dto = $dtoReflector->newInstanceWithoutConstructor();
            $this->mapAttributesToDto($domainModel, $dto);
            return $dto;
        } catch (Throwable $throwable) {
            throw new PbxException($throwable->getMessage(), $throwable->getCode(), $throwable);
        }
    }

    /**
     * @param object $domainModel
     * @param object $dto
     * @return void
     * @throws ReflectionException
     */
    private function mapAttributesToDto(object $domainModel, object $dto): void
    {
        $domainModelReflector = $this->getReflectionClass($domainModel);
        $dtoReflector = $this->getReflectionClass($dto);
        foreach ($dtoReflector->getProperties() as $dtoProperty) {
            foreach ($domainModelReflector->getProperties() as $domainModelProperty) {
                $this->mapPropertiesToDto($domainModel, $dto, $domainModelProperty, $dtoProperty);
                $this->mapHasOneToDto($domainModel, $dto, $domainModelProperty, $dtoProperty);
                $this->mapHasManyToDto($domainModel, $dto, $domainModelProperty, $dtoProperty);
            }
        }
    }

    /**
     * @param object $object
     * @param object $dto
     * @param ReflectionProperty $domainModelReflectionProperty
     * @param ReflectionProperty $dtoReflectionProperty
     * @return void
     */
    private function mapPropertiesToDto(
        object $object,
        object &$dto,
        ReflectionProperty $domainModelReflectionProperty,
        ReflectionProperty $dtoReflectionProperty
    ): void {
        $attribute = $this->attributeInstance(
            $domainModelReflectionProperty,
            Property::class
        );
        if (is_null($attribute) or $attribute->mapWithDtoProperty !== $dtoReflectionProperty->getName()) {
            return;
        }
        if ($attribute->typecast) {
            $dtoReflectionProperty->setValue(
                $dto,
                $domainModelReflectionProperty->getValue($object)->value
            );
            return;
        }
        if ($attribute->toCollection) {
            $dtoReflectionProperty->setValue(
                $dto,
                $domainModelReflectionProperty->getValue($object)->toArray()
            );
            return;
        }
        $dtoReflectionProperty->setValue(
            $dto,
            $domainModelReflectionProperty->getValue($object)
        );
    }

    private function mapHasManyToDto(
        object $model,
        object &$dto,
        ReflectionProperty $modelReflectionProperty,
        ReflectionProperty $dtoReflectionProperty
    ): void {
        $attribute = $this->attributeInstance(
            $modelReflectionProperty,
            HasManyModels::class
        );
        if (is_null($attribute) or $attribute->dtoProperty !== $dtoReflectionProperty->getName()) {
            return;
        }
        $arrayModels = $modelReflectionProperty->getValue($model)->toArray();
        $nestedDtos = [];
        foreach ($arrayModels as $domainModel) {
            $nestedDtos[] = $this->mapModelToDto($domainModel);
        }
        $dtoReflectionProperty->setValue(
            $dto,
            $nestedDtos
        );
    }
}