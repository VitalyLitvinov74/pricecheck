<?php

namespace app\domain\Product\UseCase;

use app\domain\ParseDocument\Models\ProductCard;
use app\domain\Product\Models\Attribute;
use app\domain\Product\Persistence\ProductRepository;
use app\domain\Product\Product;
use app\forms\ProductAttributeForm;
use app\forms\ProductPropertyForm;
use Doctrine\Common\Collections\ArrayCollection;
use yii\web\UploadedFile;

class ProductsService
{
    public function __construct(
        private ProductRepository          $productRepository = new ProductRepository()
    )
    {
    }

    /**
     * @param ProductAttributeForm[] $productAttributes
     *
     */
    public function createProduct(array $productAttributes): void
    {
        $product = new Product();
        foreach ($productAttributes as $attribute){
            $property = $this->productRepository->findPropertyById($attribute->property->id);
            $product->attachWith(
                new Attribute(
                    $property,
                    $attribute->value
                )
            );
        }
        $this->productRepository->saveAll(new ArrayCollection([$product]));
    }

    /**
     * @param ArrayCollection<int, ProductCard> $productsCards
     * @return void
     */
    public function createByDocument(UploadedFile $file, string $parsingSchemaId): void
    {
        $filename = $file->baseName . '.' . $file->extension;
        $products = $this->productRepository->loadFromDocument($file->tempName,$filename,  $parsingSchemaId);
        $this->productRepository->saveAll($products);
    }
}