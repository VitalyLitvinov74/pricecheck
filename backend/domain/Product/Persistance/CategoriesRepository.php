<?php

namespace app\domain\Product\Persistance;

use app\collections\ProductPropertyCollection;
use app\domain\Product\Models\Category;
use app\libs\ObjectMapper\ObjectMapper;
use Doctrine\Common\Collections\ArrayCollection;

class CategoriesRepository
{
    public function __construct(private ObjectMapper $objectMapper = new ObjectMapper())
    {
    }

    /**
     * @return ArrayCollection<int, Category>
     */
    public function findAll(): ArrayCollection
    {

    }

    public function find(string $id): Category
    {
        $result = ProductPropertyCollection::find()
            ->select([
                'supportProperties'
            ])
            ->where(['id'=>$id])
            ->asArray()
            ->one();
        return $this->objectMapper->map($result, Category::class);
    }
}