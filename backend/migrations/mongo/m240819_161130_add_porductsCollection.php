<?php

class m240819_161130_add_porductsCollection extends \yii\mongodb\Migration
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
