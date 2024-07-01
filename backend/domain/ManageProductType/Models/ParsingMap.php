<?php

namespace app\domain\ManageProductType\Models;

use Doctrine\Common\Collections\ArrayCollection;

class ParsingMap
{
    /**
     * @param  string  $name
     * @param  ArrayCollection<int, RelationshipPair>  $relationshipPairs
     */
    public function __construct(
        private string $name,
        private ArrayCollection $relationshipPairs = new ArrayCollection()
    )
    {
    }

    public function addRelationshipPair(string $name, string $externalName): void
    {
        $relationChanged = false;
        foreach ($this->relationshipPairs as $relationshipPair) {
            if ($relationshipPair->hasName($name)) {
                $relationshipPair->changeRelation($externalName);
                $relationChanged = true;
                break;
            }
        }
        if ($relationChanged === false) {
            $this->relationshipPairs->add(
                new RelationshipPair($name, $externalName)
            );
        }
    }
}