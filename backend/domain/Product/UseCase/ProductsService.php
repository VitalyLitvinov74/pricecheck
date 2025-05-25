<?php

namespace app\domain\Product\UseCase;

use app\domain\Product\Persistence\ProductRepository;
use app\exceptions\BaseException;
use app\modules\Product\domain\Models\Attribute;
use app\modules\Product\domain\Product;
use app\modules\Product\infrastructure\repositories\ProductElasticRepository;
use app\modules\Product\presentation\forms\AttributeForm;
use app\modules\Product\presentation\forms\ProductForm;
use Throwable;
use yii\db\Exception;
use yii\web\UploadedFile;

class ProductsService
{
    public function __construct(
        private ProductRepository $productRepository = new ProductRepository(),
        private ProductElasticRepository $elasticProductRepository = new ProductElasticRepository()
    )
    {
    }

    /**
     * @param AttributeForm[] $productAttributes
     * @throws Exception
     * @throws Throwable
     */
    public function createProduct(array $productAttributes): void
    {
        $product = new Product();
        foreach ($productAttributes as $attribute) {
            try {
                $property = $this->productRepository->findPropertyById($attribute->propertyForm->id);
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
        $this->productRepository->save($product);
        $this->elasticProductRepository->save($product);
    }

    /**
     * @param UploadedFile $file
     * @param string $parsingSchemaId
     * @return void
     * @throws BaseException
     * @throws Exception
     * @throws Throwable
     */
    public function createByDocument(UploadedFile $file, string $parsingSchemaId): void
    {
        $filename = $file->baseName . '.' . $file->extension;
        $products = $this->productRepository->loadFromDocument($file->tempName, $filename, $parsingSchemaId);
        $this->productRepository->saveAll($products);
        $this->elasticProductRepository->saveAll($products);
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
        $this->elasticProductRepository->save($product);
    }

    public function reindexProductsInElastic()
    {

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