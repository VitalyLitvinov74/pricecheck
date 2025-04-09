<?php

namespace app\commands;

use app\application\Product\ReindexProductsAction;
use app\records\elastic\ProductIndex;
use yii\console\Controller;

class ProductController extends Controller
{
    public ReindexProductsAction $reindexAction;
    public function init()
    {
        parent::init();
        $this->reindexAction = new ReindexProductsAction();

    }

    public function actionReindexInElastic(){
        $this->reindexAction->__invoke();
        echo "Products reindexed in ElasticSearch successfully.\n";
    }

    public function actionRemoveAllFromElastic()
    {
        ProductIndex::deleteAll();
    }
}