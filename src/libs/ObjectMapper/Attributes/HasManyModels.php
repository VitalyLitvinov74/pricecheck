<?php

namespace app\modules\pbx\libs\ObjectMapper\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class HasManyModels
{
    public function __construct(
        public string $dtoProperty,
        public string $nestedModelTypes
    ) {
    }
}