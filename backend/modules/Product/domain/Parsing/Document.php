<?php

namespace app\modules\Product\domain\Parsing;


use app\modules\Product\domain\Parsing\Models\MappingSchema;
use app\modules\Product\domain\Parsing\Models\ProductCard;
use app\modules\Product\domain\Parsing\Models\XlsxFile;
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
        private string|null $passedName = null
    ) {
        $this->version = time();
        $this->productCards = new ArrayCollection();
    }

    /**
     * @param  MappingSchema  $mappingSchema
     * @return ArrayCollection<int, ProductCard>
     */
    public function parseUse(MappingSchema $mappingSchema): ArrayCollection
    {
        $xlsx = new XlsxFile($this->path);
        foreach ($xlsx->rows() as $key => $row) {
            $product = $mappingSchema->convertRowToProductCard($row, $this->version);
            if ($product !== null) {
                $this->productCards->add($product);
            }
        }
        return $this->productCards;
    }
}