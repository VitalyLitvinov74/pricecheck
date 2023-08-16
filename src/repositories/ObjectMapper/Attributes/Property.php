<?php

namespace app\modules\pbx\repositories\ObjectMapper\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Property
{
    public function __construct(
        public string $dtoProperty,
        public string|null $typecast = null,
        public $defaultValue = null
    )
    {
    }
}