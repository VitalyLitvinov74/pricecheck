<?php

namespace app\domain\ParsingSchema\Models;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;
use Doctrine\Common\Collections\ArrayCollection;
#[DomainModel]
class RelationshipPair
{
    /**
     * @param string $productPropertyName
     * @param string $externalFieldName
     */
    public function __construct(
        #[Property(mapWithArrayKey: 'productPropertyId')]
        private string $productPropertyId,
        #[Property(mapWithArrayKey: 'externalFieldName')]
        private string $externalFieldName
    ) {
    }

    public function changeRelation(string $newName, string $newFieldName): void
    {
        $existNeighbouringPairWithIdenticalName = $this->neighboringPairs->exists(function ($key, RelationshipPair $pair){
            return $pair->hasNameProperty($this->productPropertyId);
        });
        if($existNeighbouringPairWithIdenticalName){

        }
        $this->productPropertyId = $newName;
        $this->externalFieldName = $newFieldName;
    }

    public function hasNameProperty(string $name): bool
    {
        return strtolower($this->productPropertyId) === strtolower($name);
    }


}