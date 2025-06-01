<?php

namespace app\modules\Product\presentation\controllers;

use app\controllers\BaseApiController;
use app\modules\Product\application\Parsing\ParsingService;
use app\modules\Product\presentation\forms\DocumentForm;
use Yii;

class ParseController extends BaseApiController
{
    private ParsingService $parsingService;
    public function init()
    {
        parent::init();
        $this->parsingService = new ParsingService();
    }

    public function actionInit(): array
    {
        $form = new DocumentForm();
        $form->load(Yii::$app->request->post());
        if ($form->validate()) {
            $this->parsingService->parse(
                $form->fileForParse->tempName,
                $form->parsingSchemaId
            );
            return $this->jsonApi
                ->setupCode(204)
                ->asArray();
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }
}