<?php

namespace app\domain\ManageParsingMaps;

use app\domain\ManageProductType\Models\RelationshipPair;
use Doctrine\Common\Collections\ArrayCollection;

class ParsingMap
{
    private ArrayCollection $productLinkedMaps;
    public function __construct(
        private string $productTypeId,
        private string $name,
        private int $startWithRowNum = 2,
        private ArrayCollection $relationshipPairs = new ArrayCollection(),
    ) {
    }

    public function changeName(string $newName): void
    {
        $this->name = $newName;
    }

    public function changeStartingRowNum(int $rowNum): void
    {
        $this->startWithRowNum = $rowNum;
    }

    public function replaceRelationshipsPairs(ArrayCollection $relationshipsPairs): void
    {
        $this->relationshipPairs = $relationshipsPairs;
    }

    public function addRelationshipsPair(RelationshipPair $relationshipPair): void
    {
        $this->relationshipPairs->add($relationshipPair);
    }
}