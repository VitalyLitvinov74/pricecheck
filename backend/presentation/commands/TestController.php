<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\presentation\commands;

use app\domain\ParseDocument\Document;
use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TestController extends Controller
{
    public function actionSearch()
    {
        $repo = Yii::$app->cycle->repository(Document::class);
        $document =  $repo->findOne();
        $tt = $document;
    }
}
