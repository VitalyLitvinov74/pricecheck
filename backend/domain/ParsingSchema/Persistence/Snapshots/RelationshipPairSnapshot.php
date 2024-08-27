<?php

namespace app\domain\ParsingSchema\Persistence\Snapshots;

readonly class RelationshipPairSnapshot
{
    public function __construct(
        public string $productPropertyName,
        public string $externalFieldName
    )
    {
    }
}