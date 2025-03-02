<?php

namespace app\infrastructure\libs\ObjectMapper\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Property extends PropertyAttribute
{
    /**
     * @param string|null $defaultMapWith
     * @param string|null $mapWithArrayKey
     * @param string|null $mapWithObjectKey
     * @param string|null $typecast
     * @param bool $toCollection
     */
    public function __construct(
        public string|null $defaultMapWith = null,
        public string|null $mapWithArrayKey = null,
        public string|null $mapWithObjectKey = null,
        public string|null $typecast = null,
        public bool $toCollection = false,
    ) {
    }
}