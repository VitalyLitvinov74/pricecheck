<?php

namespace app\domain\Product\UseCase;

use app\domain\ParseDocument\Models\ProductCard;
use app\domain\Product\Persistance\CategoriesRepository;
use app\domain\Product\Persistance\ProductRepository;
use app\domain\Product\Product;
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
     * @return string - id созданного продукта
     */
    public function createProduct(): string
    {
        
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