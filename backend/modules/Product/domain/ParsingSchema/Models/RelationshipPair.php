<?php

namespace app\modules\Product\domain\ParsingSchema\Models;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;
use app\modules\Product\domain\ParsingSchema\Persistence\Snapshots\RelationshipPairSnapshot;

class RelationshipPair
{
    private int|null $id = null;

    /**
     * @param string $productPropertyId
     * @param string $externalFieldName
     */
    public function __construct(
        private string $productPropertyId,
        private string $externalFieldName
    )
    {
    }

    public function changeRelation(string $relatedWithPropertyID, string $relatedWithExternalField): void
    {
        $this->productPropertyId = $relatedWithPropertyID;
        $this->externalFieldName = $relatedWithExternalField;
    }

    public function hasId(mixed $id): bool
    {
        return $this->id === $id;
    }
}