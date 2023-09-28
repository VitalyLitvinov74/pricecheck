<?php

namespace app\domain\ParseDocument;

use app\domain\ParseDocument\Models\MappingSchema;
use app\domain\ParseDocument\Models\Product;
use app\domain\ParseDocument\Models\XlsxFile;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Doctrine\Common\Collections\ArrayCollection;

#[Entity(table: 'price_lists')]
class Document
{
    #[Column(type: 'integer', name: 'id', primary: true)]
    private int $version;

    #[HasMany(target: Product::class, innerKey: 'id', outerKey: 'price_list_id')]
    /** @var ArrayCollection<int, Product> $products */
    private ArrayCollection $products;

    public function __construct(
        private string $path,
        private MappingSchema $parseSchema
    ) {
        $this->products = new ArrayCollection();
    }

    public function parse(): void
    {
        $file = new XlsxFile($this->path);
        foreach ($file->rows() as $row){
            $this->parseSchema->extractData($row);
            $this->products->add($this->parseSchema->convertToProduct());
        }
    }
}