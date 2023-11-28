<?php

/**
 * @var View $this
 * @var MappingSchemaForm $form
 */

use app\forms\MappingSchemaBunchForm;
use app\forms\MappingSchemaForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Создание схемы сопоставления';
$activeElement = ActiveForm::begin();
echo $activeElement->field($form, 'name');
$bunchElement = ActiveForm::begin();


foreach ($form->bunches as $bunch){

}
ActiveForm::end();
ActiveForm::end();