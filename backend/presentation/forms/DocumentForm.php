<?php

namespace app\presentation\forms;

use app\infrastructure\libs\NestedForm;
use yii\web\UploadedFile;

class DocumentForm extends NestedForm
{
    /**
     * @var UploadedFile
     */
    public $fileForParse;
    private const fileForParse = 'fileForParse';

    public $toCategory;
    private const toCategory = 'toCategory';

    public $useParsingSchema;
    private const useParsingSchema = 'useParsingSchema';

    public function rules(): array
    {
        return [
            [[self::useParsingSchema, self::toCategory, self::fileForParse], 'required'],
            [[self::toCategory, self::useParsingSchema], 'string'],
            [['fileForParse'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
        ];
    }

    public function formName(): string
    {
        return '';
    }


    protected function nestedFormsMap(): array
    {
        return [];
    }
}