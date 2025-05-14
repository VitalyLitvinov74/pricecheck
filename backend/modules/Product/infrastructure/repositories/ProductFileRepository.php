<?php

namespace app\modules\Product\infrastructure\repositories;

use app\domain\ParseDocument\Models\ProductCard;
use app\domain\ParseDocument\Persistance\Snapshots\DocumentSnapshot;
use app\domain\ParseDocument\UseCases\DocumentsParseService;
use app\modules\Product\domain\Models\Attribute;
use app\modules\Product\domain\Product;
use Doctrine\Common\Collections\ArrayCollection;

class ProductFileRepository
{
    /**
     * @param string $documentPath
     * @param string $passedName
     * @param string $parsingSchemaId
     * @return ArrayCollection<int|Product>
     */
    public function loadFromDocument(string $documentPath, string $passedName, string $parsingSchemaId): ArrayCollection
    {
        $parseService = new DocumentsParseService();
        /** @var ProductCard[] $result */
        $result = $parseService->parse($documentPath, $passedName, $parsingSchemaId);
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