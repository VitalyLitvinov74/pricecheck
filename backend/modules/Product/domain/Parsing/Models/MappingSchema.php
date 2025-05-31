<?php

namespace app\modules\Product\domain\Parsing\Models;

use Doctrine\Common\Collections\ArrayCollection;

class MappingSchema
{
    private int $startWithRowNum;

    /**
     * @var ArrayCollection<int, MappingPair>
     */
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
                    new CartAttribute(
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