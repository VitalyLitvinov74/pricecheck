<?php

namespace app\domain\ParsingSchema\Models;

use app\domain\ParsingSchema\Persistence\Snapshots\RelationshipPairSnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;

#[DomainModel (mapWith: RelationshipPairSnapshot::class)]
class RelationshipPair
{
    #[Property(
        defaultMapWith: 'id'
    )]
    private int|null $id = null;

    /**
     * @param string $productPropertyId
     * @param string $externalFieldName
     */
    public function __construct(
        #[Property(
            mapWithArrayKey: 'property_id',
            mapWithObjectKey: 'propertyId'
        )]
        private string $productPropertyId,

        #[Property(
            mapWithArrayKey: 'external_column_name',
            mapWithObjectKey: 'externalColumnName'
        )]
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