<?php

namespace app\domain\ManageCategory\UseCases;

use app\domain\ManageCategory\CategoryException;
use app\domain\ManageCategory\Models\Schema;
use app\domain\ManageCategory\Persistence\CategoryRepository;
use app\domain\ManageCategory\Category;
use app\forms\CategoryForm;
use app\forms\RelationPairForm;
use app\libs\LibsException;
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
     * @throws LibsException
     */
    public function create(CategoryForm $form): string
    {
        $category = new Category($form->title);
        foreach ($form->properties as $field) {
            $category->addField(
                $field->name,
                $field->type
            );
        }
        return $this->categoryRepository->save($category);
    }

    public function change(): void
    {

    }
}