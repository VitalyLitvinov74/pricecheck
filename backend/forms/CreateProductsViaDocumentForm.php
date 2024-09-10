<?php

namespace app\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class CreateProductsViaDocumentForm extends Model
{
    public $table;
    public $parsingSchemaId;

    public function rules(): array
    {
        return [
            ['table', 'file', 'extensions' => 'xlsx'],
            [['parsingSchemaId', 'table'], 'required',  'skipOnEmpty' => false]
        ];
    }

    public function load($data, $formName = null)
    {
        $loadded =  parent::load($data, $formName);
        $this->table = UploadedFile::getInstanceByName( 'table');
        if ($this->table === null){
            return false;
        }
        return $loadded;
    }
}