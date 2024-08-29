<?php

namespace app\domain\ParseDocument\Models;

use app\domain\Product\Models\Attribute;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property as Prop;
use Doctrine\Common\Collections\ArrayCollection;
use MongoDB\BSON\ObjectId;

#[DomainModel]
class MappingSchema
{
    #[Prop(
        defaultMapWith: 'startWithRowNum'
    )]
    private int $startWithRowNum;

    /**
     * @var ArrayCollection<int, MappingPair>
     */
    #[HasManyModels(
        nestedType: MappingPair::class,
        defaultMapWith: ''
    )]
    private ArrayCollection $mappingPairs;

    private function __construct()
    {
    }

    /**
     * @param XlsxRow $row
     * @param int $parsingVersion
     * @return ProductCard|null
     */
    public function convertRowToProductCard(XlsxRow $row, int $parsingVersion): ProductCard|null
    {
        if ($row->numMoreThan($this->startWithRowNum - 1)) {
            return null;
        }
        $properties = new ArrayCollection();
        foreach ($this->mappingPairs as $schemaPair) {
            foreach ($row->cells() as $cell) {
                if (!$cell->hasColumnName($schemaPair->externalName())) {
                    continue;
                }
                $properties->add(
                    new Attribute(
                        $schemaPair->propertyId(),
                        $cell->valueBy(
                            $schemaPair->type()
                        )
                    )
                );
            }
        }
        return new ProductCard(
            $parsingVersion,
            $properties
        );
    }
}