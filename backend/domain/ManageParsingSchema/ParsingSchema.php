<?php

namespace app\domain\ManageParsingSchema;

use app\domain\ManageCategory\CategoryException;
use app\domain\ManageParsingSchema\Models\RelationshipPair;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel]
class ParsingSchema
{
    /**
     * @param string $name
     * @param int $startWithRowNum
     * @param ArrayCollection<int, RelationshipPair> $relationshipPairs
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

    public function changeRelationPairLink(string|null $oldName, string $newProductPropertyName, string $newFieldName): void
    {
        if($oldName !== null && ){

        }


        if ($oldName) {
            $pair = $this->relationshipPairs->findFirst(function ($key, RelationshipPair $relationshipPair) use ($oldName
            ) {
                return $relationshipPair->hasNameProperty($oldName);
            });
        }
        if (is_null($pair) || is_null($oldName)) {
            $pair = new RelationshipPair(
                $newProductPropertyName,
                $newFieldName
            );
            $this->relationshipPairs->add($pair);
            return;
        }
        $pair->changeRelation($newProductPropertyName, $newFieldName);
    }

    private function pairByName(string $productPropertyName): null|RelationshipPair
    {
        return $this->relationshipPairs->findFirst(
            function (int $key, RelationshipPair $pair) use ($productPropertyName) {
                return $pair->hasNameProperty($productPropertyName);
            });
    }
}