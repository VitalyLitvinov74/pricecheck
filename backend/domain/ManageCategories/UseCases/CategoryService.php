<?php

namespace app\domain\ManageCategories\UseCases;

use app\domain\ManageCategories\CategoryException;
use app\domain\ManageCategories\Models\Schema;
use app\domain\ManageCategories\Persistence\CategoryRepository;
use app\domain\ManageCategories\Category;
use app\forms\CategoryForm;
use app\forms\RelationPairForm;
use yii\mongodb\Exception;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository = new CategoryRepository()
    ) {
    }

    /**
     * @param  CategoryForm  $form
     * @return string - id
     * @throws Exception
     */
    public function create(CategoryForm $form): string
    {
        $productType = new Category($form->title);
        foreach ($form->properties as $field) {
            $productType->addField(
                $field->name,
                $field->type
            );
        }
        return $this->categoryRepository->save($productType);
    }

    /**
     * @param  string  $schemaName
     * @param  int  $startParseFromRowNum
     * @param  RelationPairForm[]  $map
     * @param  string  $categoryId
     * @return void
     * @throws CategoryException
     */
    public function addParsingSchemaTo(string $schemaName, int $startParseFromRowNum, array $map, string $categoryId): void
    {
        $category = $this->categoryRepository->findById($categoryId);
        $schema = new Schema($schemaName, $startParseFromRowNum);
        foreach ($map as $pairForm) {
            $schema->addRelationshipPair(
                $pairForm->productPropertyName,
                $pairForm->externalFieldName
            );
        }
        $category->addParsingSchema($schema);
        $this->categoryRepository->save($category);
    }

    public function change(): void
    {

    }
}