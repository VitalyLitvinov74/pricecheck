<?php

namespace app\domain\ManageProductType\Models;

class ProductField
{
    public function __construct(
        private string $name,
        private string $type
    ) {
    }
}