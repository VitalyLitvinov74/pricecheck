<?php

namespace app\domain\ParsingSchema\Persistence\Snapshots;

readonly class RelationshipPairSnapshot
{
    public function __construct(
        public int|null $id,
        public string $propertyId,
        public string $externalColumnName
    )
    {
    }
}