<?php

namespace app\modules\pbx\libs\ObjectMapper\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Property
{
    /**
     * @param string $mapWithDtoProperty
     * @param string|null $typecast
     * @param bool $toCollection
     */
    public function __construct(
        public string $mapWithDtoProperty,
        public string|null $typecast = null,
        public bool $toCollection = false
    ) {
    }
}