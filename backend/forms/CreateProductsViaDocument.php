<?php

namespace app\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class CreateProductsViaDocument extends Model
{
    public UploadedFile $table;
    public $parsingSchemaId;

    public function rules(): array
    {
        return [
            ['table', 'file', 'extensions' => 'xlsx'],
            [['parsingSchemaId', 'table'], 'required',  'skipOnEmpty' => false]
        ];
    }
}