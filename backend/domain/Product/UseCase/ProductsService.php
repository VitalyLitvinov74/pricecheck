<?php

namespace app\domain\Product\UseCase;

use app\domain\ParseDocument\Models\ProductCard;
use app\domain\Product\Models\Attribute;
use app\domain\Product\Models\ValueType;
use app\domain\Product\Persistance\PropertyTemplateRepository;
use app\domain\Product\Persistance\ProductRepository;
use app\domain\Product\Product;
use app\forms\ProductPropertyForm;
use Doctrine\Common\Collections\ArrayCollection;
use yii\web\UploadedFile;

class ProductsService
{
    public function __construct(
        private PropertyTemplateRepository $propertyRepository = new PropertyTemplateRepository(),
        private ProductRepository          $productRepository = new ProductRepository()
    )
    {
    }

    /**
     * @param ProductPropertyForm[] $productProperties
     * @return string - id созданного продукта
     *
     */
    public function createProduct(array $productProperties): void
    {
        $product = new Product();
        foreach ($productProperties as $property){

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