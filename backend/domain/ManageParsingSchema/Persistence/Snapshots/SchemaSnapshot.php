<?php

namespace app\domain\ManageParsingSchema\Persistence\Snapshots;

readonly class SchemaSnapshot
{
    /**
     * @param int $categoryId
     * @param string $name
     * @param int $startWithRowNum
     * @param RelationshipPairSnapshot[] $relationshipPairs
     */
    public function __construct(
       public int    $categoryId,
       public string $name,
       public int    $startWithRowNum,
       public array  $relationshipPairs
    )
    {
    }
}