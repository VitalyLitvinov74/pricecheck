<?php

namespace app\domain\Product\UseCase;

use app\domain\ParseDocument\Models\ProductCard;
use app\domain\Product\Models\Property;
use app\domain\Product\Models\ValueType;
use app\domain\Product\Persistance\CategoriesRepository;
use app\domain\Product\Persistance\ProductRepository;
use app\domain\Product\Product;
use app\forms\ProductTypeForm;
use Doctrine\Common\Collections\ArrayCollection;

class ProductsService
{
    public function __construct(
        private CategoriesRepository $categoriesRepository = new CategoriesRepository(),
        private ProductRepository $productRepository = new ProductRepository()
    )
    {
    }

    /**
     * @param ProductTypeForm[] $productProperties
     * @return string - id созданного продукта
     *
     */
    public function createProduct(string $categoryId, array $productProperties): string
    {
        $category = $this->categoriesRepository->find($categoryId);
        $product = new Product($category);
        foreach ($productProperties as $property){
            $product->add(
                new Property(
                    $property->name,
                    $property->value,
                    ValueType::string
                )
            );
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