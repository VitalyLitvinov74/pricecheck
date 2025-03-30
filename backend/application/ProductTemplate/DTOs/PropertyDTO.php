<?php

namespace app\application\ProductTemplate\DTOs;

class PropertyDTO
{
    public function __construct(
        public string $name,
        public int $type,
        public int|null $id = null)
    {
    }
}