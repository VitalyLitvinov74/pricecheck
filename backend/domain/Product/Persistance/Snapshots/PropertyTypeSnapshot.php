<?php

namespace app\domain\Product\Persistance\Snapshots;

class PropertyTypeSnapshot
{
    public function __construct(
        public string $name,
        public int $id
    )
    {
    }
}