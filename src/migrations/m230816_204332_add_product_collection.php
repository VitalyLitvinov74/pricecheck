<?php

class m230816_204332_add_product_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('products');
    }

    public function down()
    {
        $this->dropCollection('products');
    }
}
