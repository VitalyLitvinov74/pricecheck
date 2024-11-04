<?php

namespace app\domain\Property\Persistence\snapshots;

class PropertySnapshot
{
    /**
     * @param int|null $id
     * @param string $name
     * @param string $type
     * @param SettingSnapshot[] $settingsSnapshots
     */
    public function __construct(
        public int|null $id,
        public string $name,
        public string $type,
        public array $settingsSnapshots
    )
    {
    }
}