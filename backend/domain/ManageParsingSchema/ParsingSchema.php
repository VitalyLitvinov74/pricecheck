<?php

namespace app\domain\ManageParsingSchema;

use app\domain\ManageParsingSchema\Models\RelationshipPair;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\HasOneModel;
use app\libs\ObjectMapper\Attributes\Property;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel]
class ParsingSchema
{
    /**
     * @param string $categoryId
     * @param string $name
     * @param int $startWithRowNum
     * @param ArrayCollection<int, RelationshipPair> $relationshipPairs
     */
    public function __construct(
        #[Property(mapWithArrayKey: "categoryId")]
        private string          $categoryId,
        #[Property(mapWithArrayKey: 'name')]
        private string          $name,
        #[Property(mapWithArrayKey: 'startWithRowNum')]
        private int             $startWithRowNum = 2,
        #[HasManyModels(
            nestedType: RelationshipPair::class,
            mapWithArrayKey: 'relationshipPairs'
        )]
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