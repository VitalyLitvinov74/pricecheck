<?php

namespace app\domain\ParsingSchema;

use app\domain\ParsingSchema\Models\RelationshipPair;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\HasOneModel;
use app\libs\ObjectMapper\Attributes\Property;
use Doctrine\Common\Collections\ArrayCollection;
use MongoDB\BSON\ObjectId;

#[DomainModel]
class ParsingSchema
{
    /**
     * @param string $name
     * @param int $startWithRowNum
     * @param ArrayCollection<int, RelationshipPair> $relationshipPairs
     * @param ObjectId $id
     */
    public function __construct(
        #[Property(mapWithArrayKey: 'name')]
        private string          $name,
        #[Property(mapWithArrayKey: 'startWithRowNum')]
        private int             $startWithRowNum = 2,
        #[HasManyModels(
            nestedType: RelationshipPair::class,
            mapWithArrayKey: 'relationshipPairs'
        )]
        private ArrayCollection $relationshipPairs = new ArrayCollection(),
        #[Property(mapWithArrayKey: '_id')]
        private ObjectId $id = new ObjectId()
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