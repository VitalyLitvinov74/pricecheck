<?php

namespace app\libs\ObjectMapper\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class DomainModel
{
    public function __construct(
        public string $mapWith = ''
    ) {
    }
}