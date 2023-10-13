<?php

namespace app\modules\pbx\libs\ObjectMapper\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class DomainModel
{
    public function __construct(
        public string $mappedWithDto
    ) {
    }
}