<?php

class m231205_180818_addProductCardCollection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('product_cards');
    }

    public function down()
    {
        $this->dropCollection('product_cards');
    }
}
