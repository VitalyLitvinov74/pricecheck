<?php

namespace app\libs\ObjectMapper\Mapping\MappingModes;

use app\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use app\libs\ObjectMapper\ReflectionTrait;
use ReflectionProperty;
use yii\helpers\ArrayHelper;

class ArrayToModelMode implements MappingModeStrategyInterface
{
    use ReflectionTrait;

    public function __construct()
    {
    }

    /**
     * @param mixed $from
     * @param mixed $to
     *
     * @return void
     * @throws ImpossibleIsNotMapping
     */
    public function map(mixed $from, mixed &$to): void
    {
        if (!is_array($from)) {
            throw new ImpossibleIsNotMapping(
                'Не возможно произвести маппинг, поскольку мы должны мапить из массива в существующий объект модели. Однако на вход мы получаем не массив.'
            );
        }
        if (!is_object($to)) {
            throw new ImpossibleIsNotMapping(
                'Не возможно произвести маппинг, поскольку мы должны мапить из массива в существующий объект модели. Однако объекта не существует.'
            );
        }

        $modelReflectionClass = $this->getReflectionClass($to);
        foreach ($modelReflectionClass->getProperties() as $modelReflectionProperty) {
            $attributeInstance = $this->extractAttributeInstance($modelReflectionProperty);
            if ($attributeInstance === null) {
                continue; //т.е. не нужно мапить это свойство модели. (у него отсутствует атрибут)
            }

            $arrayKey = $attributeInstance->foreignKey(MappingMode::arrayToModel);
            if ($arrayKey === null) {
                continue; // нет инфы о внешнем ключе, значит свойство модели маппиь не нужно
            }

            $value = $this->defineValue($from, $arrayKey, $modelReflectionProperty);

            $propertyStrategy = $this->defineStrategyWorkWithModelProperty(
                $attributeInstance,
                MappingMode::arrayToModel
            );

            $propertyStrategy->hydrateModelProperty(
                $to,
                $modelReflectionProperty,
                $value
            );
        }
    }

    /**
     * @param array $from
     * @param string|int $arrayKey
     * @param ReflectionProperty $modelReflectionProperty
     *
     * @return mixed
     * @throws ImpossibleIsNotMapping
     */
    private function defineValue(
        array $from,
        string|int $arrayKey,
        ReflectionProperty $modelReflectionProperty
    ): mixed {
        $value = ArrayHelper::getValue($from, $arrayKey, 'keyIsNull');
        $arrayHasKey = $value !== 'keyIsNull';
        if (
            !$arrayHasKey
            && !$modelReflectionProperty->hasDefaultValue()
            && !$modelReflectionProperty->getType()->allowsNull()
        ) {
            throw new ImpossibleIsNotMapping(
                sprintf(
                    'Отсутствует ключ %s в массиве, на который ссылается свойство %s в модели %s',
                    $arrayKey,
                    $modelReflectionProperty->getName(),
                    $modelReflectionProperty->getDeclaringClass()->getName()
                )
            );
        }
        if (!$arrayHasKey && $modelReflectionProperty->hasDefaultValue()) {
            return $modelReflectionProperty->getDefaultValue();
        }

        if (!$arrayHasKey && $modelReflectionProperty->getType()->allowsNull()) {
            return null;
        }
        return $value;
    }
}