<?php

namespace app\modules\Product\application;


use app\modules\Product\application\DTOs\AttributeDTO;
use app\modules\Product\domain\Models\Attribute;
use app\modules\Product\domain\Product;
use app\modules\Product\infrastructure\repositories\ProductPgRepository;

class ProductService
{
    public function __construct(private ProductPgRepository $productRepository)
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
        return $this->productRepository->save($product);
    }

    public function update($data)
    {

    }
}