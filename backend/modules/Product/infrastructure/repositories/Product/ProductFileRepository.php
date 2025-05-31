<?php

namespace app\modules\Product\infrastructure\repositories\Product;

use app\modules\Product\application\Parsing\ParsingService;
use app\modules\Product\domain\ParceDocument\Document;
use app\modules\Product\domain\ParceDocument\Persistance\Snapshots\DocumentSnapshot;
use app\modules\Product\domain\Product\Models\Attribute;
use app\modules\Product\domain\Product\Product;
use Doctrine\Common\Collections\ArrayCollection;

class ProductFileRepository
{
    public function __construct(private ParsingService $parseService = new ParsingService())
    {
    }

    /**
     * @param string $documentPath
     * @param string $passedName
     * @param string $parsingSchemaId
     * @return ArrayCollection<int|Product>
     */
    public function loadFromDocument(string $documentPath, string $passedName, string $parsingSchemaId): ArrayCollection
    {
        /** @var Document[] $result */
        $result = $this->parseService->parse($documentPath, $passedName, $parsingSchemaId);
        $products = new ArrayCollection();
        $documentSnapshot = $this->objectMapper->map($result, DocumentSnapshot::class);
        foreach ($documentSnapshot->productsCardsSnapshots as $productCardSnapshot) {
            $product = new Product();
            foreach ($productCardSnapshot->productCardPropertiesSnapshots as $propertySnapshot) {
                $product->attachWith(
                    new Attribute(
                        $this->findPropertyById($propertySnapshot->id),
                        $propertySnapshot->value
                    )
                );
            }
            $products->add($product);
        }
        return $products;
    }
}