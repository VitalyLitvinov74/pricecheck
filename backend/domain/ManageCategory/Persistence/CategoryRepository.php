<?php

namespace app\domain\ManageCategory\Persistence;

use app\collections\CategoryCollection;
use app\domain\ManageCategory\Category;
use app\domain\ManageCategory\CategoryException;
use app\libs\ObjectMapper\ObjectMapper;
use Yii;

class CategoryRepository
{
    public function __construct(
        private ObjectMapper  $objectMapper = new ObjectMapper(),
    )
    {
    }

    /**
     * @param Category $category
     * @return string - id сохраненной записи
     */
    public function create(Category $category): string
    {
        $data = $this->objectMapper->map($category, []);
        $result = Yii::$app->mongodb
            ->createCommand()
            ->insert(
                CategoryCollection::collectionName(),
                $data,
                ['upsert' => true]
            );
        return $result->jsonSerialize()['$oid'];
    }

    public function findById(string $id): Category
    {
        $record = CategoryRecord::find()
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