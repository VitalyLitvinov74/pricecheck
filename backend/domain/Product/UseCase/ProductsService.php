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
    public function createProduct(array $productProperties): void
    {
        $product = new Product();
        foreach ($productProperties as $property){
            if($property->id && $this->propertyRepository->exist($property->id)){
                $propertyId = $property->id;
            }

            if($property->name && $property->id === null){
                $propertyId = $this->propertyRepository->idByName($property->name);
            }

            $property = new Property($propertyId, $property->value);
            $product->add($property);
        }
        $this->productRepository->saveAll([$product]);
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