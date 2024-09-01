<?php

namespace app\domain\ParsingSchema\Models;

use app\domain\ParsingSchema\Persistence\Snapshots\RelationshipPairSnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;
#[DomainModel (mapWith: RelationshipPairSnapshot::class)]
class RelationshipPair
{
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
    ) {
    }

    public function changeRelation(string $newName, string $newFieldName): void
    {
//        $existNeighbouringPairWithIdenticalName = $this->neighboringPairs->exists(function ($key, RelationshipPair $pair){
//            return $pair->hasNameProperty($this->productPropertyId);
//        });
//        if($existNeighbouringPairWithIdenticalName){
//
//        }
//        $this->productPropertyId = $newName;
//        $this->externalFieldName = $newFieldName;
    }

    public function hasNameProperty(string $name): bool
    {
        return strtolower($this->productPropertyId) === strtolower($name);
    }


}