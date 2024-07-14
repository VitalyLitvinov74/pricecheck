<?php

namespace app\domain\ManageCategories\Models;

use Doctrine\Common\Collections\ArrayCollection;

class Schema
{
    /**
     * @param  string  $name
     * @param  ArrayCollection<int, RelationshipPair>  $relationshipPairs
     */
    public function __construct(
        private string $name,
        private int $startWithRowNum = 2,
        private ArrayCollection $relationshipPairs = new ArrayCollection(),
    ) {
    }

    public function addRelationshipPair(string $name, string $externalName, string $productExternalName = ''): void
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
                new RelationshipPair($name, $externalName, $productExternalName)
            );
        }
    }

    public function hasName(string $name): bool
    {
        return $this->name === $name;
    }

    public function compareWith(Schema $schema): bool {
        return $schema->hasName($this->name);
    }
}