<?php

namespace app\domain\Product\Persistence\Snapshots;

class PropertyTypeSnapshot
{
    public function __construct(
        public string $name,
        public int $id
    )
    {
    }
}