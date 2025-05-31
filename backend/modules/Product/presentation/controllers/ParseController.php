<?php

namespace app\modules\Product\presentation\controllers;

use app\controllers\BaseApiController;
use app\modules\Product\application\Parsing\DocumentsParseService;
use app\modules\Product\presentation\forms\DocumentForm;
use Yii;

class ParseController extends BaseApiController
{
    private DocumentsParseService $parsingService;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

    }

    public function actionInit(): array
    {
        $form = new DocumentForm();
        $form->load(Yii::$app->request->post());
        if ($form->validate()) {
            //https://github.com/mikemadisonweb/yii2-rabbitmq/blob/master/README.md?ysclid=mb3ujowj3g293955264
            $this->parsingService->parse($form->parsingSchemaId, $form->fileForParse);
            return $this->jsonApi
                ->setupCode(204)
                ->asArray();
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }
}