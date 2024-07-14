<?php

namespace app\domain\ManageCategories\Persistence;

use app\domain\ManageCategories\Category;
use app\domain\ManageCategories\CategoryException;
use app\libs\ObjectMapper\ObjectMapper;
use app\records\CategoriesCollection;
use yii\mongodb\Exception;

class CategoryRepository
{
    public function __construct(
        private ObjectMapper $objectMapper = new ObjectMapper()
    ) {
    }

    /**
     * @param  Category  $category
     * @return string - id сохраненной записи
     * @throws Exception
     */
    public function save(Category $category): string
    {
        $data = $this->objectMapper->map($category, []);
        return CategoriesCollection::getCollection()
            ->update([], $data, ['upsert' => true]);
    }

    public function findById(string $id): Category
    {
        $record = CategoriesCollection::find()
            ->where(['_id' => $id])
            ->asArray()
            ->one();
        if (is_null($record)) {
            throw new CategoryException(sprintf(
                'Категория с id = %s не найдена',
                $id
            ));
        }
        $category = $this->objectMapper->map($record, Category::class);
        return $category;
    }
}