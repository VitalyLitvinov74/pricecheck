<?php

namespace app\domain\ManageParsingMaps;

use app\domain\ManageParsingMaps\Models\RelationshipPair;
use Doctrine\Common\Collections\ArrayCollection;

class ParsingMap
{
    private ArrayCollection $productLinkedMaps;

    /**
     * @param  string  $productTypeId
     * @param  string  $name
     * @param  int  $startWithRowNum
     * @param  ArrayCollection<int, RelationshipPair>  $relationshipPairs
     */
    public function __construct(
        private string $productTypeId,
        private string $name,
        private int $startWithRowNum = 2,
        private ArrayCollection $relationshipPairs = new ArrayCollection(),
    ) {
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function changeStartingRowNum(int $rowNum): void
    {
        $this->startWithRowNum = $rowNum;
    }

    public function changeRelationPairLink(string $pairName, string $newName, string $newFieldName): void
    {
        $pair = $this->relationshipPairs->findFirst(function ($key, RelationshipPair $relationshipPair) use ($pairName) {
            return $relationshipPair->hasNameProperty($pairName);
        });
        if (is_null($pair)) {
            return;
        }
        $pair->changeRelation($newName, $newFieldName);
    }
}