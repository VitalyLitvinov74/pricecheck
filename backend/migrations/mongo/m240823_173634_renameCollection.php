<?php

class m240823_173634_renameCollection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->db->createCommand(
            [ 'renameCollection' => 'pricecheck.categories', 'to' => 'pricecheck.productsTypes'],
  'admin'
        )->execute();
    }

    public function down()
    {
        $this->db->createCommand(
            [ 'renameCollection' => 'pricecheck.productsTypes', 'to' => 'pricecheck.categories'],
            'admin'
        )->execute();
    }
}
