<?php

namespace app\records\pg\queries;

use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;

class ProductQuery extends ActiveQuery
{
    public function forProductDomain(): self
    {
        return $this->with([
            'productAttributes' => function (Query $query) {
                $query->emulateExecution();
            },
            'productAttributes.property' => function (Query $query) {
                $query->emulateExecution();
            }
        ]);
    }

    /**
     * @param string $fieldName
     * @param array $values
     * @return $this|self - реализует кастомную сортировку по заданному полю ($fieldName) в строго указанном порядке ($values)
     * Это полезно, т.к. при получении результатов из elasticsearch нет гарантиии сохранения верного порядока сортировки
     */
    public function strictOrderBy(string $fieldName, array $values): self
    {
        if (empty($values)) {
            return $this;
        }
        $cases = '';
        foreach ($values as $key => $value) {
            $key++;
            $cases .= " when $value then $key ";
        }
        $lastKey = $key + 1;
        return $this->orderBy(new Expression("case $fieldName $cases else $lastKey end"));
    }
}