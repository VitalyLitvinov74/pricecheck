<?php

namespace app\infrastructure\libs\ObjectMapper\Attributes;

use app\infrastructure\libs\ObjectMapper\Mapping\MappingModes\MappingMode;

abstract class PropertyAttribute
{
    public string|null $defaultMapWith;
    public string|null $mapWithArrayKey;
    public string|null $mapWithObjectKey;

    /**
     * @param MappingMode $mappingMode
     *
     * @return string|null - Получает внешний ключ (например ключ массива или внешнего объекта), с которым нужно мапить
     *     свойство модели, к которому прикреплен текущий атрибут.
     */
    public function foreignKey(MappingMode $mappingMode): string|null
    {
        $key = $this->defaultMapWith;
        if ($this->isArrayMode($mappingMode) && $this->mapWithArrayKey !== null) {
            $key = $this->mapWithArrayKey;
        }

        if ($this->isObjectMode($mappingMode) && $this->mapWithObjectKey !== null) {
            $key = $this->mapWithObjectKey;
        }

        return $key;
    }

    private function isArrayMode(MappingMode $mode): bool
    {
        return $mode === MappingMode::arrayToModel || $mode === MappingMode::modelToArray;
    }

    private function isObjectMode(MappingMode $mode): bool
    {
        return $mode === MappingMode::objectToModel || $mode === MappingMode::modelToObject;
    }
}