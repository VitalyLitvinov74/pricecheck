<?php

namespace app\modules\pbx\repositories\ObjectMapper\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class DomainModel
{
    public function __construct(
        public string $mappedWithDto
    )
    {
    }
}