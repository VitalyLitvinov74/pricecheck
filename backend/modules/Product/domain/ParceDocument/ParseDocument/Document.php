<?php

namespace app\modules\Product\domain\ParceDocument\ParseDocument;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property;
use app\modules\Product\domain\ParceDocument\ParseDocument\Models\MappingSchema;
use app\modules\Product\domain\ParceDocument\ParseDocument\Models\ProductCard;
use app\modules\Product\domain\ParceDocument\ParseDocument\Models\XlsxFile;
use app\modules\Product\domain\ParceDocument\ParseDocument\Persistance\Snapshots\DocumentSnapshot;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel (mapWith: DocumentSnapshot::class)]
class Document
{
    #[Property(mapWithObjectKey: 'version')] /** @see DocumentSnapshot::$version */
    private int $version;

    /**
     * @var ArrayCollection<int, ProductCard>
     */
    #[HasManyModels(
        nestedType: ProductCard::class,
        mapWithObjectKey: 'productsCardsSnapshots' /** @see DocumentSnapshot::$productsCardsSnapshots */
    )]
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