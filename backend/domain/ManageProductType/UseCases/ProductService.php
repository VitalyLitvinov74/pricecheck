<?php

namespace app\domain\ManageProductType\UseCases;

use app\domain\ManageProductType\Models\ParsingMap;
use app\domain\ManageProductType\Persistence\ProductCardRepository;
use app\domain\ManageProductType\ProductType;
use app\forms\ProductTypeForm;
use app\forms\RelationPairForm;
use yii\mongodb\Exception;

class ProductService
{
    public function __construct(
        private ProductCardRepository $productTypeRepository = new ProductCardRepository()
    )
    {
    }

    /**
     * @param  ProductTypeForm  $form
     * @return string - id
     * @throws Exception
     */
    public function createProductType(ProductTypeForm $form): string
    {
        $productType = new ProductType($form->title);
        foreach ($form->properties as $field){
            $productType->addField(
                $field->name,
                $field->type
            );
        }
        return $this->productTypeRepository->save($productType);
    }

    /**
     * @param  string  $name
     * @param  RelationPairForm[]  $map
     * @param  string  $productTypeId
     * @return void
     */
    public function addParsingSchemaTo(string $name, int $startParseFromRowNum, array $map, string $productTypeId): void
    {
        $productType = $this->productTypeRepository->findById($productTypeId);
        $parsingMap = new ParsingMap($name, $startParseFromRowNum);
        foreach ($map as $pairForm){
            $parsingMap->addRelationshipPair(
                $pairForm->productPropertyName,
                $pairForm->productPropertyName
            );
        }
        $productType->addParsingMap($name, $parsingMap);
    }
}