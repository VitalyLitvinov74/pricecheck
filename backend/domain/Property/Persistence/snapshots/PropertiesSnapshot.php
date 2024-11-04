<?php

namespace app\domain\Property\Persistence\snapshots;

class PropertiesSnapshot
{
    /**
     * @param PropertySnapshot[] $collection
     */
    public function __construct(
        public array $collection
    )
    {
    }
}