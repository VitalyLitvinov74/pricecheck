<?php

class m231110_181417_add_mapping_schema_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('mapping_schemas');
    }

    public function down()
    {
        $this->dropCollection('mapping_schemas');
    }
}
