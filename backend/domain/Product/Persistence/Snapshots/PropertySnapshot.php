<?php

namespace app\domain\Product\Persistence\Snapshots;

class PropertySnapshot
{
    public function __construct(
        public int|null|string $id,
        public string $name
    )
    {
    }
}