<?php

namespace app\domain\Product\UseCase;

use app\domain\Product\Models\Attribute;
use app\domain\Product\Persistence\ProductRepository;
use app\domain\Product\Product;
use app\exceptions\BaseException;
use app\forms\ProductAttributeForm;
use Doctrine\Common\Collections\ArrayCollection;
use Throwable;
use yii\web\UploadedFile;

class ProductsService
{
    public function __construct(
        private ProductRepository $productRepository = new ProductRepository()
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
        foreach ($productAttributes as $attribute) {
            try {
                $property = $this->productRepository->findPropertyById($attribute->property->id);
                $product->attachWith(
                    new Attribute(
                        $property,
                        $attribute->value
                    )
                );
            }catch (Throwable $throwable){
                continue;
            }
        }
        $this->productRepository->saveAll(new ArrayCollection([$product]));
    }

    /**
     * @param UploadedFile $file
     * @param string $parsingSchemaId
     * @return void
     * @throws BaseException
     */
    public function createByDocument(UploadedFile $file, string $parsingSchemaId): void
    {
        $filename = $file->baseName . '.' . $file->extension;
        $products = $this->productRepository->loadFromDocument($file->tempName, $filename, $parsingSchemaId);
        $this->productRepository->saveAll($products);
    }

    public function remove($id): void
    {
        $this->productRepository->remove($id);
    }

    private function existProperty(int $id): bool{
        $properties = $this->productRepository->availableProperties();
        foreach ($properties as $property){
            if($property->hasId($id)){
                return true;
            }
        }
        return false;
    }
}