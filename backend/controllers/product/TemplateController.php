<?php

namespace app\controllers\product;

use app\application\ProductTemplate\ActualizePropertiesAction;
use app\controllers\BaseApiController;
use app\forms\ProductTemplateForm;
use Yii;

class TemplateController extends BaseApiController
{
    private ActualizePropertiesAction $actualizePropertiesAction;

    public function init(): void
    {
        parent::init();
        $this->actualizePropertiesAction = new ActualizePropertiesAction();
    }

    public function actionIndex()
    {

    }

    public function actionActualizeProperties(): array
    {
        $form = new ProductTemplateForm();
        $form->load(Yii::$app->request->post());
        if ($form->validate()) {
            $this->actualizePropertiesAction->__invoke(
                $form->propertiesDTOs()
            );
            return $this->jsonApi->setupCode(201)->asArray();
        }
        return $this->jsonApi->setupCode(422)->addModelErrors($form)->asArray();
    }
}