<?php

class m240827_150916_addSchemaCollection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('parsingSchemas');
    }

    public function down()
    {
        $this->dropCollection('parsingSchemas');
    }
}
