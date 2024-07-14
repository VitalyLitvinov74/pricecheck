<?php

namespace app\domain\ParseDocument;

use app\domain\ParseDocument\Models\XlsxRow;
use app\domain\ParseDocument\Models\MappingSchema;
use app\domain\ParseDocument\Models\ProductCard;
use app\domain\ParseDocument\Models\Category;
use app\domain\ParseDocument\Models\XlsxFile;
use Doctrine\Common\Collections\ArrayCollection;

class Document
{
    private int $version;

    public function __construct(
        private string        $path,
    )
    {
        $this->version = time();
    }

    /**
     * @param  MappingSchema  $mappingSchema
     * @return ArrayCollection<int, ProductCard>
     */
    public function parseUse(MappingSchema $mappingSchema): ArrayCollection
    {
        $xlsx = new XlsxFile($this->path);
        $products = new ArrayCollection();
        foreach ($xlsx->rows() as $row){
            $product = $mappingSchema->convertRowToProductCard($row);
            $products->add($product);
        }
        return $products;
    }
}