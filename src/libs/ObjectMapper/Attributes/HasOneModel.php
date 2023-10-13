<?php

namespace app\modules\pbx\libs\ObjectMapper\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class HasOneModel
{
    public function __construct(
        public string $dtoProperty
    ) {
    }
}