<?php

namespace app\controllers\api;

use app\domain\ParseDocument\UseCases\DocumentsParseService;
use app\forms\DocumentForm;

class DocumentController extends BaseApiController
{
    private DocumentsParseService $documentService;
    public function init(): void
    {
        $this->documentService = new DocumentsParseService();
        parent::init();
    }

    public function actionParseToCategory(): array
    {
        $form = new DocumentForm();
        if($form->load($this->request->post()) and $form->validate()){
            try {
                $this->documentService->parse(
                    $form->fileForParse->tempName,
                    $form->toCategory,
                    $form->useParsingSchema
                );
                return $this->jsonApi->setupCode(204)->asArray();
            }catch (\Throwable $exception){
                return $this->jsonApi->addException($exception)->asArray();
            }
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }
}