<?php

namespace app\domain\Product\UseCase;

use app\domain\Product\Models\Attribute;
use app\domain\Product\Persistence\ProductRepository;
use app\domain\Product\Product;
use app\infrastructure\exceptions\BaseException;
use app\presentation\forms\ProductAttributeForm;
use app\presentation\forms\ProductForm;
use Doctrine\Common\Collections\ArrayCollection;
use Throwable;
use yii\db\Exception;
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
            } catch (Throwable $throwable) {
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

    /**
     * @param ProductForm $form
     * @return void
     * @throws BaseException
     * @throws Throwable
     * @throws Exception
     */
    public function update(ProductForm $form): void
    {
//        $product2 = $this->productRepository->find2($form->id);
//        throw new Exception('asd');
        $product = $this->productRepository->find($form->id);
        foreach ($form->productAttributes as $attribute) {
            $property = $this->productRepository->findPropertyById($attribute->property->id);
            $product->attachWith(
                new Attribute(
                    $property,
                    $attribute->value,
                )
            );
        }
        $this->productRepository->save($product);
    }

    private function existProperty(int $id): bool
    {
        $properties = $this->productRepository->availableProperties();
        foreach ($properties as $property) {
            if ($property->hasId($id)) {
                return true;
            }
        }
        return false;
    }
}