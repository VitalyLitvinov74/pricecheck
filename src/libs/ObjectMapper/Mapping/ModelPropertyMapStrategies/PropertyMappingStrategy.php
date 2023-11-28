<?php

namespace app\libs\ObjectMapper\Mapping\ModelPropertyMapStrategies;

use app\libs\ObjectMapper\Attributes\Property;
use app\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use Doctrine\Common\Collections\ArrayCollection;
use ReflectionProperty;

class PropertyMappingStrategy implements ModelPropertyMapStrategy
{
    use CheckingTrait;

    /**
     * @param Property $attributeInstance
     */
    public function __construct(private Property $attributeInstance)
    {
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

        $attributeInstance = $this->attributeInstance;

        if ($attributeInstance->typecast && $value !== null) {
            $value = $attributeInstance->typecast::from($value);
        }

        if ($attributeInstance->toCollection && $value !== null) {
            if (is_array($value) === false) {
                throw new ImpossibleIsNotMapping(
                    sprintf(
                        'Передаваемое значение в свойство %s модели %s должно быть массивом',
                        $modelReflectionProperty->getName(),
                        $modelReflectionProperty->getDeclaringClass()->getName()
                    )
                );
            }

            //это массив который нужно преобразовать в коллекцию
            $value = new ArrayCollection($value);
        }

        $modelReflectionProperty->setValue(
            $modelInstance,
            $value
        );
    }

    /**
     * @param object $modelInstance
     * @param ReflectionProperty $modelReflectionProperty
     *
     * @return mixed
     * @throws ImpossibleIsNotMapping
     */
    public function extractModelProperty(
        object $modelInstance,
        ReflectionProperty $modelReflectionProperty
    ): mixed {
        $value = $modelReflectionProperty->getValue($modelInstance);

        if (is_null($value) && $modelReflectionProperty->getType()->allowsNull()) {
            return null;
        }

        $this->throwExceptionIfPropertyCannotBeNull($value, $modelReflectionProperty);

        $attributeInstance = $this->attributeInstance;
        if ($attributeInstance->typecast) {
            return $value->value;
        }

        if ($attributeInstance->toCollection) {
            if ($value instanceof ArrayCollection === false) {
                throw new ImpossibleIsNotMapping(
                    sprintf(
                        'Свойство %s в модели %s должно быть коллекцией',
                        $modelReflectionProperty->getName(),
                        $modelReflectionProperty->getDeclaringClass()->getName()
                    )
                );
            }

            //это коллекция которую нужно преобразовать в массив
            return $value->toArray();
        }

        return $value;
    }
}