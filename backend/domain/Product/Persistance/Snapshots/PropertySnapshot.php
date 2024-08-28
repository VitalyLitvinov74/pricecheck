<?php

namespace app\domain\Product\Persistance\Snapshots;

class PropertySnapshot
{
    public function __construct(
        public $id,
        public $value
    )
    {
    }
}