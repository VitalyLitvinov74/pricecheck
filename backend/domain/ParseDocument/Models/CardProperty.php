<?php

namespace app\domain\ParseDocument\Models;

use app\domain\ParseDocument\Persistance\Snapshots\ProductCardPropertySnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;

#[DomainModel (mapWith: ProductCardPropertySnapshot::class)]
class CardProperty
{
    public function __construct(
        #[Property(defaultMapWith: 'id')]
        private string $id,
        #[Property(defaultMapWith: 'value')]
        private mixed $value
    ) {}
}