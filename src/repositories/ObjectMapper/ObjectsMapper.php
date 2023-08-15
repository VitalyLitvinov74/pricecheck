<?php

namespace app\modules\pbx\repositories\ObjectMapper;

use app\modules\pbx\repositories\ObjectMapper\Attributes\DomainModel;
use app\modules\pbx\repositories\ObjectMapper\Attributes\HasManyModels;
use app\modules\pbx\repositories\ObjectMapper\Attributes\HasOneModel;
use app\modules\pbx\repositories\ObjectMapper\Attributes\Property;
use Doctrine\Common\Collections\ArrayCollection;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
class ObjectsMapper
{
    public function __construct()
    {

    }

    /**
     * @param string $target
     * @param object|null $dto
     * @return object
     * @throws \ReflectionException
     */
    public function hydrate(string $target, object|null $dto): object
    {
        $reflector = $this->getReflectionClass($target);
        $object = $reflector->newInstanceWithoutConstructor();
        $objectProperties = $this->getReflectionClass($object)->getProperties();
        foreach ($objectProperties as $objectProperty) {
            $this->hydrateProperties($object, $dto, $objectProperty);
            $this->hydrateHasOne($object, $dto, $objectProperty);
            $this->hydrateHasMany($object, $dto, $objectProperty);
        }
        return $object;
    }

    private function hydrateProperties(object &$object, object $dto, ReflectionProperty $objectProperty): void
    {
        /** @var Property $attribute */
        $attribute = $this->attributeInstance($objectProperty, Property::class);
        if (is_null($attribute)) {
            return;
        }
        $dtoPropertyName = $attribute->dtoProperty;
        if ($attribute->typecast) { //это класс Enum
            $enum = $attribute->typecast::from($dto->$dtoPropertyName);
            $objectProperty->setValue($object, $enum);
            return;
        }
        $objectProperty->setValue($object, $dto->$dtoPropertyName);
    }

    private function hydrateHasOne(object &$object, object $dto, ReflectionProperty $objectProperty): void
    {
        /** @var HasOneModel $attribute */
        $attribute = $this->attributeInstance($objectProperty, HasOneModel::class);
        if (is_null($attribute)) {
            return;
        }
        $dtoPropertyName = $attribute->dtoProperty;
        if($dto->$dtoPropertyName === null){
            $objectProperty->setValue($object, null);
            return;
        }
        $propertyType = $objectProperty->getType();
        $nestedObject = $this->hydrate($propertyType->getName(), $dto->$dtoPropertyName);
        $objectProperty->setValue($object, $nestedObject);
    }

    private function hydrateHasMany(object &$object, object $dto, ReflectionProperty $objectProperty): void
    {
        /** @var HasManyModels $attribute */
        $attribute = $this->attributeInstance($objectProperty, HasManyModels::class);
        if (is_null($attribute)) {
            return;
        }
        $dtoPropertyName = $attribute->dtoProperty;
        $nestedModels = [];
        foreach ($dto->$dtoPropertyName as $nestedDto) {
            $nestedModels[] = $this->hydrate($attribute->nestedModelTypes, $nestedDto);
        }
        $objectProperty->setValue($object, new ArrayCollection($nestedModels));
    }


    /**
     * преобразует объект во вложенный ДТО который указан в атрибутах объекта     *
     */
    public function mapObjectToDto(object|null $object): object|null
    {
        if($object===null){
            return null;
        }
        $domainModelReflector = $this->getReflectionClass($object);
        $attributesDomainModels = $domainModelReflector->getAttributes(DomainModel::class);
        if (empty($attributesDomainModels)) {
            throw new DomainModelAttributeNotFound($object::class);
        }
        /** @var DomainModel $attributeDomainModel */
        $attributeDomainModel = $attributesDomainModels[0]->newInstance();
        $dtoReflector = $this->getReflectionClass($attributeDomainModel->mappedWithDto);
        $dto = $dtoReflector->newInstanceWithoutConstructor();
        $this->mapAttributesToDto($object, $dto);
        return $dto;
    }

    /**
     * @param object $object
     * @param object $dto
     * @param ReflectionProperty $domainModelReflectionProperty
     * @param ReflectionProperty $dtoReflectionProperty
     * @return void
     */
    private function mapPropertiesToDto(
        object             $object,
        object             &$dto,
        ReflectionProperty $domainModelReflectionProperty,
        ReflectionProperty $dtoReflectionProperty
    ): void
    {
        /** @var Property $attribute */
        $attribute = $this->attributeInstance(
            $domainModelReflectionProperty,
            Property::class
        );
        if (is_null($attribute) or $attribute->dtoProperty !== $dtoReflectionProperty->getName()) {
            return;
        }
        if ($attribute->typecast) {
            $dtoReflectionProperty->setValue(
                $dto,
                $domainModelReflectionProperty->getValue($object)->value
            );
        } else {
            $dtoReflectionProperty->setValue(
                $dto,
                $domainModelReflectionProperty->getValue($object)
            );
        }

    }

    private function mapHasOneToDto(
        object             $object,
        object             &$dto,
        ReflectionProperty $domainReflectionProperty,
        ReflectionProperty $dtoReflectionProperty
    ): void
    {
        /** @var HasOneModel $attribute */
        $attribute = $this->attributeInstance($domainReflectionProperty, HasOneModel::class);
        if (is_null($attribute) or $attribute->dtoProperty !== $dtoReflectionProperty->getName()) {
            return;
        }
        $dtoReflectionProperty->setValue(
            $dto,
            $this->mapObjectToDto(
                $domainReflectionProperty->getValue($object)
            )
        );
    }

    private function mapHasManyToDto(
        object             $object,
        object             &$dto,
        ReflectionProperty $domainModelReflectionProperty,
        ReflectionProperty $dtoReflectionProperty
    ): void
    {
        /** @var HasManyModels $attribute */
        $attribute = $this->attributeInstance(
            $domainModelReflectionProperty,
            HasManyModels::class
        );
        if (is_null($attribute) or $attribute->dtoProperty !== $dtoReflectionProperty->getName()) {
            return;
        }
        $arrayModels = $domainModelReflectionProperty->getValue($object)->toArray();
        $nestedDtos = [];
        foreach ($arrayModels as $domainModel) {
            $nestedDtos[] = $this->mapObjectToDto($domainModel);
        }
        $dtoReflectionProperty->setValue(
            $dto,
            $nestedDtos
        );
    }

    private function mapAttributesToDto(object $object, object $dto): void
    {
        $domainModelReflector = $this->getReflectionClass($object);
        $dtoReflector = $this->getReflectionClass($dto);
        foreach ($dtoReflector->getProperties() as $dtoProperty) {
            foreach ($domainModelReflector->getProperties() as $domainModelProperty) {
                $this->mapPropertiesToDto($object, $dto, $domainModelProperty, $dtoProperty);
                $this->mapHasOneToDto($object, $dto, $domainModelProperty, $dtoProperty);
                $this->mapHasManyToDto($object, $dto, $domainModelProperty, $dtoProperty);
            }
        }
    }

    /**
     * @param ReflectionProperty $property
     * @param string $attributeName
     * @return object|null
     */
    private function attributeInstance(ReflectionProperty $property, string $attributeName): object|null
    {
        if (empty($property->getAttributes($attributeName))) {
            return null;
        }
        return $property->getAttributes($attributeName)[0]->newInstance();
    }

    private function getReflectionClass($target)
    {
        static $reflectionClassMap = [];
        $className = is_object($target) ? get_class($target) : $target;
        if (!isset($reflectionClassMap[$className])) {
            $reflectionClassMap[$className] = new ReflectionClass($className);
        }
        return $reflectionClassMap[$className];
    }
}