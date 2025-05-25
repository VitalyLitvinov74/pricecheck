<?php

namespace app\modules\Product\domain\ParceDocument\ParseDocument\Models;

use app\domain\ParseDocument\Persistance\Snapshots\MappingSchemaSnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property as Prop;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel]
class MappingSchema
{
    #[Prop(
        defaultMapWith: 'start_with_row_num',
    )]
    private int $startWithRowNum;

    /**
     * @var ArrayCollection<int, MappingPair>
     */
    #[HasManyModels(
        nestedType: MappingPair::class,
        defaultMapWith: 'parsingSchemaProperties',
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
        if ($row->numMoreThan($this->startWithRowNum) === false) {
            return null;
        }
        $properties = new ArrayCollection();
        foreach ($this->mappingPairs as $schemaPair) {
            foreach ($row->cells() as $cell) {
                if (!$cell->hasColumnName($schemaPair->externalName())) {
                    continue;
                }
                $properties->add(
                    new CardProperty(
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