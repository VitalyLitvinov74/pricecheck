<?php

namespace app\domain\ManageProductCard\Models;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;

#[DomainModel]
class CardField
{
    public function __construct(
        #[Property(mapWithArrayKey: 'name')]
        private string $name
    ) {
    }
}