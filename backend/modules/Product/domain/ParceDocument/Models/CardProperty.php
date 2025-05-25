<?php

namespace app\modules\Product\domain\ParceDocument\Models;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;
use app\modules\Product\domain\ParceDocument\Persistance\Snapshots\ProductCardPropertySnapshot;

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