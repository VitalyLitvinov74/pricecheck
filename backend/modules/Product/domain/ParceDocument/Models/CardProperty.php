<?php

namespace app\modules\Product\domain\ParceDocument\Models;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;
use app\modules\Product\domain\ParceDocument\Persistance\Snapshots\ProductCardPropertySnapshot;

#[DomainModel (mapWith: ProductCardPropertySnapshot::class)]
class CardProperty
{
    public function __construct(
        private string $id,
        private mixed $value
    ) {}
}