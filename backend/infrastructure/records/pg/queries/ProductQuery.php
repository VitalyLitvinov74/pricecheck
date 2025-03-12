<?php

namespace app\infrastructure\records\pg\queries;

use yii\db\ActiveQuery;
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
}