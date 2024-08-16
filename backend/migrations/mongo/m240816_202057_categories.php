<?php

class m240816_202057_categories extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('categories');
    }

    public function down()
    {
        $this->dropCollection('categories');
    }
}
