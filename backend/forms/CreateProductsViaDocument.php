<?php

namespace app\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class CreateProductsViaDocument extends Model
{
    public UploadedFile|null $table;
    public $parsingSchemaId;

    public function rules(): array
    {
        return [
            ['table', 'file', 'extensions' => 'xlsx, xls'],
            [['parsingSchemaId', 'file'], 'required',  'skipOnEmpty' => false]
        ];
    }
}