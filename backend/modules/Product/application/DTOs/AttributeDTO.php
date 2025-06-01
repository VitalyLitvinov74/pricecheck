<?php

namespace app\modules\Product\application\DTOs;

class AttributeDTO
{
    public function __construct(
        public int $propertyId,
        public string $value,
        public int|null $id = null,
    )
    {
    }
}