<?php

/**
 * @var View $this
 * @var MappingSchemaForm $form
 */

use app\forms\MappingSchemaForm;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Создание схемы сопоставления';
$activeElement = ActiveForm::begin();
echo $activeElement->field($form, 'name');
echo $activeElement
ActiveForm::end();