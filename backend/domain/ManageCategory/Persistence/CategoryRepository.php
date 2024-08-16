<?php

namespace app\domain\ManageCategory\Persistence;

use app\domain\ManageCategory\Category;
use app\domain\ManageCategory\CategoryException;
use app\domain\ManageCategory\Persistence\Snapshots\CategorySnapshot;
use app\domain\ManageCategory\Persistence\Snapshots\FieldSnapshot;
use app\libs\LibsException;
use app\libs\UpsertBuilder;
use app\libs\ObjectMapper\ObjectMapper;
use app\records\CategoryFieldsRecord;
use app\records\CategoryRecord;
use Yii;

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
     * @throws LibsException
     */
    public function save(Category $category): string
    {
        $snapshot = $this->objectMapper->map($category, CategorySnapshot::class);
        $dataForInsert = [
            'title' => $snapshot->title
        ];
        $this->upsertBuilder
            ->useActiveRecord(CategoryRecord::class)
            ->useUniqueKeys(['title'])
            ->upsertOneRecord($dataForInsert);
        $categoryId = CategoryRecord::find()
            ->select('id')
            ->where(['title' => $snapshot->title])
            ->scalar();

        $this->saveFields($snapshot->fieldsSnapshots, $categoryId);
        return $categoryId;
    }

    /**
     * @param FieldSnapshot[] $fieldsSnapshots
     * @param int $categoryId
     * @return void
     * @throws LibsException
     */
    private function saveFields(array $fieldsSnapshots, int $categoryId): void{
        $dataForInsert = [];
        foreach ($fieldsSnapshots as $fieldSnapshot){
            $dataForInsert[] = [
                'category_id' => $categoryId,
                'name' => $fieldSnapshot->name,
                'type' => $fieldSnapshot->type,
                'state' => $fieldSnapshot->state
            ];
        }
        $this->upsertBuilder
            ->useActiveRecord(CategoryFieldsRecord::class)
            ->useUniqueKeys(['category_id', 'name'])
            ->upsertManyRecords($dataForInsert);
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