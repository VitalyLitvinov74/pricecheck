<?php

namespace app\modules\Product\presentation\forms;

use app\modules\Product\infrastructure\records\MappingSchemaRecord;
use yii\base\Model;
use yii\web\UploadedFile;

class DocumentForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $fileForParse;

    public $parsingSchemaId;

    public function load($data, $formName = null): bool
    {
        $loaded = parent::load($data, $formName);
        $this->fileForParse = UploadedFile::getInstance($this, 'fileForParse');
        return $loaded;
    }

    public function rules(): array
    {
        return [
            [['parsingSchemaId', 'fileForParse'], 'required'],
            [['parsingSchemaId'], 'integer'],
            ['parsingSchemaId',
                'exist',
                'targetClass' => MappingSchemaRecord::class,
                'targetAttribute' => 'id'
            ],
            [
                ['fileForParse'],
                'file',
                'skipOnEmpty' => false,
//                'extensions' => ['xls', 'xlsx'],
                'maxSize' => 51200000
            ],
        ];
    }

    public function formName(): string
    {
        return '';
    }
}