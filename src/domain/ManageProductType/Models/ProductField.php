<?php

namespace app\domain\ProductMetadata;

class ProductField
{
    public function __construct(
        private string $name,
        private string $type
    ) {
    }
}