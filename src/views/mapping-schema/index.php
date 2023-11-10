<?php

use yii\bootstrap5\Button;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var ActiveDataProvider $dataProvider
 */


?>
<?= Html::a('Создать новую схему', ['mapping-schema/create'],[
    'class'=> 'btn btn-success',
])?>
<br>
<br>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        '_id',
        'name'
    ]
]) ?>
