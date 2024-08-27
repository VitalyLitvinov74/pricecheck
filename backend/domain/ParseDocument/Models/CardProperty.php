<?php

namespace app\domain\ParseDocument\Models;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;

#[DomainModel]
class CardProperty
{
    public function __construct(
        #[Property(mapWithArrayKey: '_id')]
        private string $id,
        #[Property(mapWithArrayKey: 'value')]
        private mixed $value
    ) {}
}