<?php

namespace app\modules\Product\presentation\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class DocumentForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $fileForParse;

    public $parsingSchemaId;

    public function rules(): array
    {
        return [
            [['parsingSchemaId', 'fileForParse'], 'required'],
            [['parsingSchemaId'], 'integer'],
            [['fileForParse'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
        ];
    }

    public function formName(): string
    {
        return '';
    }
}