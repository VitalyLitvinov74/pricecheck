<?php

namespace app\domain\Product\UseCase;

use app\domain\ParseDocument\Models\ProductCard;
use app\domain\Product\Models\Property;
use app\domain\Product\Models\ValueType;
use app\domain\Product\Persistance\PropertyRepository;
use app\domain\Product\Persistance\ProductRepository;
use app\domain\Product\Product;
use app\forms\ProductPropertyForm;
use Doctrine\Common\Collections\ArrayCollection;

class ProductsService
{
    public function __construct(
        private PropertyRepository $propertyRepository = new PropertyRepository(),
        private ProductRepository  $productRepository = new ProductRepository()
    )
    {
    }

    /**
     * @param ProductPropertyForm[] $productProperties
     * @return string - id созданного продукта
     *
     */
    public function createProduct(, array $productProperties): string
    {
        $product = new Product();
        foreach ($productProperties as $property){
            $property = $this->propertyRepository->findBy($property->name);
            $product->add($property);
        }
        $result = $this->productRepository->save($product);
        return $result;
    }

    /**
     * @param ArrayCollection<int, ProductCard> $productsCards
     * @return void
     */
    public function createByDocument(): void
    {
        $products = $this->productRepository->getFromDocument('', '', '');
        $this->productRepository->saveAll($products);
    }
}