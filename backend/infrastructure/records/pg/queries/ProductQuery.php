<?php

namespace app\infrastructure\records\pg\queries;

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

    public function strictOrderBy(string $fieldName, array $values): self
    {
        $cases = '';
        foreach ($values as $key => $value) {
            $key++;
            $cases .= " when $value then $key ";
        }
        $lastKey = $key + 1;
        return $this->orderBy(new Expression("case $fieldName $cases else $lastKey end"));
    }
}