<?php

class m240714_153510_renameCollections extends \yii\mongodb\Migration
{
    public function up()
    {
        Yii::$app->mongodb->createCommand(
            ['renameCollection' => 'pricecheck.products_types', 'to' => 'pricecheck.categories'],
            'admin'
        )->execute();
    }

    public function down()
    {
        Yii::$app->mongodb->createCommand(
            ['renameCollection' => 'pricecheck.categories', 'to' => 'pricecheck.products_types'],
            'admin'
        )->execute();
    }
}
