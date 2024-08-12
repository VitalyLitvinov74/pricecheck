<?php

namespace app\domain\ManageParsingSchema\Models;

use app\domain\ManageCategory\CategoryException;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;
use Doctrine\Common\Collections\ArrayCollection;
#[DomainModel]
class RelationshipPair
{
    /**
     * @var ArrayCollection<int, RelationshipPair>
     */
    private ArrayCollection $neighboringPairs;

    public function __construct(
        #[Property(mapWithArrayKey: 'productPropertyName')]
        private string $productPropertyName,
        #[Property(mapWithArrayKey: 'externalFieldName')]
        private string $externalFieldName,
    ) { }

    public function changeRelation(string $newName, string $newFieldName): void
    {
        $existNeighbouringPairWithIdenticalName = $this->neighboringPairs->exists(function ($key, RelationshipPair $pair){
            return $pair->hasNameProperty($this->productPropertyName);
        });
        if($existNeighbouringPairWithIdenticalName){
            throw new CategoryException(sprintf(
                'Свойство %s уже завязано на внешнее поле',
                $newName

            ));
        }
        $this->productPropertyName = $newName;
        $this->externalFieldName = $newFieldName;
    }

    public function hasNameProperty(string $name): bool
    {
        return strtolower($this->productPropertyName) === strtolower($name);
    }


}