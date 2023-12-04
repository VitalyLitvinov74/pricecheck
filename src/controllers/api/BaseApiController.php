<?php

namespace app\controllers\api;

use app\exceptions\BaseException;
use app\libs\JsonApi;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

abstract class BaseApiController extends Controller
{
    protected JsonApi $jsonApi;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->jsonApi = new JsonApi();
    }

    public function runAction($id, $params = [])
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        try {
            return parent::runAction($id, $params);
        } catch (BaseException $exception) {
            return $this->jsonApi->addException($exception)->asArray();
        }
    }
}