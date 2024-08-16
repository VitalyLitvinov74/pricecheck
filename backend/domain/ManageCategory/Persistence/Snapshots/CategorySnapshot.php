<?php

namespace app\domain\ManageCategory\Persistence\Snapshots;

readonly class CategorySnapshot
{
    /**
     * @param string $title
     * @param FieldSnapshot[] $fieldsSnapshots
     */
    public function __construct(
        public string $title,
        public array $fieldsSnapshots
    )
    {
    }
}