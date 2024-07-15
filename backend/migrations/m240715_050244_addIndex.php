<?php

class m240715_050244_addIndex extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createIndex('categories', 'title', [
            'unique' => true
        ]);
    }

    public function down()
    {
        $this->dropIndex('categories','title');
    }
}
