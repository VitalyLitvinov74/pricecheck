<?php

namespace app\application\Product;

use app\domain\Product\Persistence\ElasticProductRepository;
use app\domain\Product\Persistence\ProductRepository;

class ReindexProductsAction
{
    public function __construct(
        private ProductRepository $productRepository = new ProductRepository(),
        private ElasticProductRepository $elasticProductRepository = new ElasticProductRepository()
    )
    {

    }

    public function __invoke(): void
    {
        $this->elasticProductRepository->saveAll(
            $this->productRepository->findAll()
        );
    }
}