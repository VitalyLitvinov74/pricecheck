<?php

namespace app\modules\Product\application;


use app\modules\Product\application\DTOs\AttributeDTO;
use app\modules\Product\domain\Product\Models\Attribute;
use app\modules\Product\domain\Product\Product;
use app\modules\Product\infrastructure\repositories\ProductElasticRepository;
use app\modules\Product\infrastructure\repositories\ProductFileRepository;
use app\modules\Product\infrastructure\repositories\ProductPgRepository;

class ProductService
{
    public function __construct(
        private ProductPgRepository $pgRepository,
        private ProductElasticRepository $elasticRepository,
        private ProductFileRepository $fileRepository
    )
    {
    }

    /**
     * @param AttributeDTO[] $attributeDTOs
     * @return int
     */
    public function create(array $attributeDTOs): int
    {
        $product = new Product();
        $product->fill(
            array_map(
                function (AttributeDTO $attributeDTO) {
                    return new Attribute(
                        $attributeDTO->propertyId,
                        $attributeDTO->propertyName,
                        $attributeDTO->value
                    );
                },
                $attributeDTOs
            )
        );
        $productId = $this->pgRepository->save($product);
        $this->elasticRepository->revalidate($productId);
        return $productId;
    }

    public function createAllFromDocument(){

    }

    public function update($data)
    {

    }
}