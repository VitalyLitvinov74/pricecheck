<?php

namespace app\presentation\commands;

use app\application\ReindexProductsAction;
use app\domain\Product\UseCase\ProductsService;
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
}