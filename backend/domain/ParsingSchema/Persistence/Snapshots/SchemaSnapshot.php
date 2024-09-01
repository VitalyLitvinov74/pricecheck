<?php

namespace app\domain\ParsingSchema\Persistence\Snapshots;

readonly class SchemaSnapshot
{
    /**
     * @param int|null $id
     * @param string $name
     * @param int $startWithRowNum
     * @param RelationshipPairSnapshot[] $relationshipPairsSnapshots
     */
    public function __construct(
        public int|null $id,
        public string   $name,
        public int      $startWithRowNum,
        public array    $relationshipPairsSnapshots
    )
    {
    }
}