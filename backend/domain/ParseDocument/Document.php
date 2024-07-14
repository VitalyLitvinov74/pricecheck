<?php

namespace app\domain\ParseDocument;

use app\domain\ParseDocument\Models\MappingSchema;
use app\domain\ParseDocument\Models\ProductCard;
use app\domain\ParseDocument\Models\XlsxFile;
use Doctrine\Common\Collections\ArrayCollection;

class Document
{
    private int $version;
    /**
     * @var ArrayCollection<int, ProductCard>
     */
    private ArrayCollection $productCards;

    public function __construct(
        private string $path,
        private string $passedName
    ) {
        $this->version = time();
        $this->productCards = new ArrayCollection();
    }

    /**
     * @param  MappingSchema  $mappingSchema
     */
    public function parseUse(MappingSchema $mappingSchema): void
    {
        $xlsx = new XlsxFile($this->path);
        foreach ($xlsx->rows() as $row) {
            $product = $mappingSchema->convertRowToProductCard($row);
            if ($product !== null) {
                $this->productCards->add($product);
            }
        }
    }
}