<?php

namespace app\modules\pbx\repositories\ObjectMapper\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class HasOneModel
{
    public function __construct(
        public string $dtoProperty,
    )
    {
    }
}