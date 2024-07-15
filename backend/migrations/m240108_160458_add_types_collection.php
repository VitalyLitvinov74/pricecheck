<?php

class m240108_160458_add_types_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('products_property_types');
        $this->createIndex('products_property_types', ['name'], ['unique'=>true]);
    }

    public function down()
    {
        $this->dropCollection('products_property_types');
    }
}
