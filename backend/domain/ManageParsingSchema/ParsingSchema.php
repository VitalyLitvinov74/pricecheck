<?php

namespace app\domain\ManageParsingSchema;

use app\domain\ManageParsingSchema\Models\RelationshipPair;
use Doctrine\Common\Collections\ArrayCollection;

class ParsingSchema
{
    private ArrayCollection $productLinkedMaps;

    /**
     * @param string $categoryId
     * @param string $name
     * @param int $startWithRowNum
     * @param ArrayCollection<int, RelationshipPair> $relationshipPairs
     */
    public function __construct(
        private string          $categoryId,
        private string          $name,
        private int             $startWithRowNum = 2,
        private ArrayCollection $relationshipPairs = new ArrayCollection(),
    )
    {
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function changeStartingRowNum(int $rowNum): void
    {
        $this->startWithRowNum = $rowNum;
    }

    public function add(RelationshipPair $pair): void
    {
    }

    public function changeRelationPairLink(string $pairName, string $newName, string $newFieldName): void
    {
        $pair = $this->relationshipPairs->findFirst(function ($key, RelationshipPair $relationshipPair) use ($pairName
        ) {
            return $relationshipPair->hasNameProperty($pairName);
        });
        if (is_null($pair)) {
            return;
        }
        $pair->changeRelation($newName, $newFieldName);
    }
}