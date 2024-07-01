<?php

namespace app\domain\ManageProductType\Models;

class RelationshipPair
{
    public function __construct(private string $productPropertyName, private string $externalProductName)
    {
    }

    public function hasName(string $name): bool
    {
        return $this->productPropertyName === $name;
    }

    public function changeRelation(string $externalName): void
    {
        $this->externalProductName = $externalName;
    }
}