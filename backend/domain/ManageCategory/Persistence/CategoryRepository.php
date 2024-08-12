<?php

namespace app\domain\ManageCategory\Persistence;

use app\collections\CategoryCollection;
use app\domain\ManageCategory\Category;
use app\domain\ManageCategory\CategoryException;
use app\libs\MongoUpsertBuilder;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\MysqlUpsertBuilder;
use Yii;

class CategoryRepository
{
    public function __construct(
        private ObjectMapper  $objectMapper = new ObjectMapper(),
        private MongoUpsertBuilder $upsertBuilder = new MongoUpsertBuilder()
    )
    {
    }

    /**
     * @param Category $category
     * @return string - id сохраненной записи
     */
    public function save(Category $category): string
    {
        $data = $this->objectMapper->map($category, []);
        $this->upsertBuilder
            ->useActiveRecord(CategoryCollection::collectionName())
            ->upsertOneRecord($data, []);
        return CategoryCollection::find()->select('id')->where(['title'=>$data['title']])->scalar();
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