<?php

namespace app\domain\Property\Persistence\snapshots;

class PropertySnapshot
{
    public function __construct(
        public int|null $id,
        public int $type,
        public array $settingsSnapshots
    )
    {
    }
}