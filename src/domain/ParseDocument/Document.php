<?php

namespace app\domain\ParseDocument;

use app\domain\ParseDocument\Models\MappingSchema;
use app\domain\ParseDocument\Models\Product;
use app\domain\ParseDocument\Models\XlsxFile;
use Doctrine\Common\Collections\ArrayCollection;

class Document
{
    /** @var ArrayCollection<int, Product> $products */
    private ArrayCollection $products;
    private int $version;

    public function __construct(
        private string        $path,
        private MappingSchema $mappingSchema
    )
    {
        $this->products = new ArrayCollection();
        $this->version = time();
    }

    public function parse(): void
    {
        $file = new XlsxFile($this->path);
        foreach ($file->rows() as $row) {
            $product = $row->convertToProduct(
                $this->mappingSchema
            );
            $this->products->add($product);
        }
    }
}