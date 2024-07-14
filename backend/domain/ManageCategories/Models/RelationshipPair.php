<?php

namespace app\domain\ManageCategories\Models;

class RelationshipPair
{
    public function __construct(private string $productPropertyName, private string $externalName, private string $externalColumnName = '')
    {
    }

    public function hasName(string $name): bool
    {
        return $this->productPropertyName === $name;
    }

    public function changeRelation(string $externalName): void
    {
        $this->externalName = $externalName;
    }
}