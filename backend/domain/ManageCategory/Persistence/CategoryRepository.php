<?php

namespace app\domain\ManageCategory\Persistence;

use app\collections\CategoryCollection;
use app\domain\ManageCategory\Category;
use app\domain\ManageCategory\CategoryException;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\records\CategoryRecord;
use Yii;
use yii\base\InvalidConfigException;
use yii\mongodb\Exception;

class CategoryRepository
{
    public function __construct(
        private ObjectMapper  $objectMapper = new ObjectMapper(),
        private UpsertBuilder $upsertBuilder = new UpsertBuilder()
    )
    {
    }

    /**
     * @param Category $category
     * @return string - id сохраненной записи
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function save(Category $category): string
    {
        $data = $this->objectMapper->map($category, []);
        Yii::$app->mongodb->createCommand()
            ->addUpdate(
                ['title' => $data['title']],
                ['$set' => $data],
                ['upsert' => true]
            )
            ->executeBatch('categories');
        return CategoryCollection::find()->select(['_id'])->where(['title'=> $data['title']])->scalar();
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