<?php

namespace app\domain\ParseDocument\Snapshots;

use app\domain\ParseDocument\Models\MappingSchema;
use app\domain\ParseDocument\Models\Product;
use Doctrine\Common\Collections\ArrayCollection;

class DocumentSnapshot
{
    /**
     * @var ProductSnapshot[]
     */
    public array $productsSnapshots;

    public MappingSchemaSnapshot $mappingSchemaSnapshot;

    public function __construct(
        public int $version,
        public string $path
    )
    {
    }

    /**
     * @param ArrayCollection<int, Product> $collection
     * @return self
     */
    public function snapProducts(ArrayCollection $collection): self
    {
        foreach ($collection as $product) {
            $this->productsSnapshots[] = $product->makeSnapshot();
        }
        return $this;
    }

    public function snapMappingSchema(MappingSchema $mappingSchema): self{
        $this->mappingSchemaSnapshot = $mappingSchema->makeSnapshot();
    }
}