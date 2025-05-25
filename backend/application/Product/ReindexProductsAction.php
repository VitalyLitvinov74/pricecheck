<?php

namespace app\application\Product;

use app\domain\Product\Persistence\ProductRepository;
use app\modules\Product\infrastructure\repositories\ProductElasticRepository;

class ReindexProductsAction
{
    public function __construct(
        private ProductRepository $productRepository = new ProductRepository(),
        private ProductElasticRepository $elasticProductRepository = new ProductElasticRepository()
    )
    {

    }

    public function __invoke(): void
    {
        $this->elasticProductRepository->revalidateOf(
            $this->productRepository->findAll()
        );
    }
}