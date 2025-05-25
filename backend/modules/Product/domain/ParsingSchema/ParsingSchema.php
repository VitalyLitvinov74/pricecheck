<?php

namespace app\modules\Product\domain\ParsingSchema;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property;
use app\modules\Product\domain\ParsingSchema\Models\RelationshipPair;
use app\modules\Product\domain\ParsingSchema\Persistence\Snapshots\SchemaSnapshot;
use Doctrine\Common\Collections\ArrayCollection;

class ParsingSchema
{
    private int|null $id = null;

    /**
     * @param string $name
     * @param int $startWithRowNum
     * @param ArrayCollection<int, RelationshipPair> $relationshipPairs
     */
    public function __construct(
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
        $this->relationshipPairs->add($pair);
    }

    public function changeRelationPairLink(
        mixed    $pairID,
        string $relatedWithExternalField,
        string $relatedWithPropertyID
    ): void
    {
        $pair = $this->relationshipPairs
            ->findFirst(
                function ($key, RelationshipPair $relationshipPair) use ($pairID) {
                    return $relationshipPair->hasId($pairID);
                });
        if (is_null($pair)) {
            $this->add(
                new RelationshipPair(
                    $relatedWithPropertyID,
                    $relatedWithExternalField
                )
            );
            return;
        }
        $pair->changeRelation($relatedWithPropertyID, $relatedWithExternalField);
    }
}