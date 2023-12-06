<?php

namespace app\libs\ObjectMapper\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class HasManyModels extends PropertyAttribute
{
    /**
     * @param string $nestedType
     * @param string|null $defaultMapWith
     * @param string|null $mapWithArrayKey
     * @param string|null $mapWithObjectKey
     */
    public function __construct(
        public string $nestedType,
        public string|null $defaultMapWith = null,
        public string|null $mapWithArrayKey = null,
        public string|null $mapWithObjectKey = null
    ) {
    }
}