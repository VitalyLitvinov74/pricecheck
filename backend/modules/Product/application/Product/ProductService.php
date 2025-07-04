<?php

namespace app\modules\Product\application\Product;


use app\modules\Product\application\DTOs\AttributeDTO;
use app\modules\Product\domain\Product\Models\Attribute;
use app\modules\Product\domain\Product\Product;
use app\modules\Product\infrastructure\repositories\Product\ProductElasticRepository;
use app\modules\Product\infrastructure\repositories\Product\ProductPgRepository;

class ProductService
{
    public function __construct(
        private ProductPgRepository $pgRepository = new ProductPgRepository(),
        private ProductElasticRepository $elasticRepository = new ProductElasticRepository()
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

    public function createFromDocument(){

    }

    public function update($data)
    {

    }
}