<?php

namespace app\domain\ParsingSchema;

use app\domain\ParsingSchema\Models\RelationshipPair;
use app\domain\ParsingSchema\Persistence\Snapshots\SchemaSnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel (mapWith: SchemaSnapshot::class)]
class ParsingSchema
{
    #[Property(defaultMapWith: 'id')]
    private int|null $id = null;

    /**
     * @param string $name
     * @param int $startWithRowNum
     * @param ArrayCollection<int, RelationshipPair> $relationshipPairs
     */
    public function __construct(
        #[Property(
            defaultMapWith: 'name'
        )]
        private string          $name,

        #[Property(
            mapWithArrayKey: 'start_with_row_num',
            mapWithObjectKey: 'startWithRowNum'
        )]
        private int             $startWithRowNum = 2,

        #[HasManyModels(
            nestedType: RelationshipPair::class,
            mapWithArrayKey: 'parsingSchemaProperties',
            mapWithObjectKey: 'relationshipPairsSnapshots'
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