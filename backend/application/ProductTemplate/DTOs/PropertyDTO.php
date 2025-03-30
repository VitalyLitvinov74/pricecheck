<?php

namespace app\application\ProductTemplate\DTOs;

class PropertyDTO
{
    public function __construct(
        public string $name,
        public string $type,
        public int|null $id = null)
    {
    }
}