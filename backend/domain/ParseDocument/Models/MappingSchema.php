<?php

namespace app\domain\ParseDocument\Models;

use Doctrine\Common\Collections\ArrayCollection;

class MappingSchema
{
    private int $startWithRowNum;

    /**
     * @var ArrayCollection<int, MappingPair>
     */
    private ArrayCollection $mappingPairs;

    private string $categoryId;


    private function __construct()
    {
    }

    /**
     * @param XlsxRow $row
     * @param int $parsingCersion
     * @return ProductCard|null
     */
    public function convertRowToProductCard(XlsxRow $row, int $parsingCersion): ProductCard|null
    {
        if ($row->numMoreThan($this->startWithRowNum - 1)) {
            return null;
        }
        $productCard = new ProductCard($this->categoryId);
        foreach ($this->mappingPairs as $pair) {
            foreach ($row->cells() as $cell) {
                if (!$cell->hasColumnName($pair->externalName())) {
                    continue;
                }
                $productCard->addProperty(
                    $pair->name(),
                    $cell->value(
                        $pair->type()
                    )
                );
            }
        }
        $productCard->addProperty('parsingVersion', $parsingCersion);
        $productCard->addProperty('categoryId', $this->categoryId);
        return $productCard;
    }
}