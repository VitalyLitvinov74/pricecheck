<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m230928_163051_add_price_list_table
 */
class m230928_163051_add_price_list_table extends Migration
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
