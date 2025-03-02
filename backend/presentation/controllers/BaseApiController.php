<?php

namespace app\presentation\controllers;

use app\infrastructure\exceptions\BaseException;
use app\infrastructure\libs\JsonApi;
use Yii;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\JsonParser;
use yii\web\Request;
use yii\web\Response;

/**
 * @property Request $request
 */
abstract class BaseApiController extends Controller
{
    protected JsonApi $jsonApi;
    public $enableCsrfValidation = false;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->jsonApi = new JsonApi();
        $this->request->parsers['application/json'] = JsonParser::class;
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

    public function behaviors(): array
    {
        return [
            [
                'class' => Cors::class,
            ]
        ];
    }
}