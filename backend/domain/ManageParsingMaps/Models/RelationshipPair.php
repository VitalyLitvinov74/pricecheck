<?php

namespace app\domain\ManageParsingMaps\Models;

use app\domain\ManageParsingMaps\ManagerParsingPair\Models\NeighboringPair;
use app\domain\ManageProductType\CategoryException;
use Doctrine\Common\Collections\ArrayCollection;

class RelationshipPair
{
    private string $productPropertyName;
    private string $externalFieldName;

    /**
     * @var ArrayCollection<int, RelationshipPair>
     */
    private ArrayCollection $neighboringPairs;

    private function __construct() { }

    public function changeRelation(string $newName, string $newFieldName): void
    {
        $existNeighbouringPairWithIdenticalName = $this->neighboringPairs->exists(function ($key, RelationshipPair $pair){
            return $pair->hasNameProperty($this->productPropertyName);
        });
        if($existNeighbouringPairWithIdenticalName){
            throw new CategoryException(sprintf(
                'Свойство %s уже завязано на внешнее поле',
                $newName

            ));
        }
        $this->productPropertyName = $newName;
        $this->externalFieldName = $newFieldName;
    }

    public function hasNameProperty(string $name): bool
    {
        return strtolower($this->productPropertyName) === strtolower($name);
    }


}