<?php

class m240218_163748_rename_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        Yii::$app->mongodb->createCommand([
            'renameCollection' => 'pricecheck.product_cards',
            'to' => 'pricecheck.products_types'
        ],'admin')->execute();
    }

    public function down()
    {
        Yii::$app->mongodb->createCommand([
            'renameCollection' => 'pricecheck.products_types',
            'to' => 'pricecheck.product_cards'
        ],'admin')->execute();
    }
}
