<?php

namespace app\domain\ManageCategory\Persistence\Snapshots;

readonly class FieldSnapshot
{
    public function __construct(
        public string $name,
        public string $state,
        public string $type
    )
    {
    }
}