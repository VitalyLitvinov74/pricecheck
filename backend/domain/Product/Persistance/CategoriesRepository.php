<?php

namespace app\domain\Product\Persistance;

use app\domain\Product\Models\Category;
use Doctrine\Common\Collections\ArrayCollection;

class CategoriesRepository
{
    /**
     * @return ArrayCollection<int, Category>
     */
    public function findAll(): ArrayCollection
    {

    }
}