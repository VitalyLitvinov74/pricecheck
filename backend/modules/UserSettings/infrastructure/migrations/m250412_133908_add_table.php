<?php

namespace app\modules\UserSettings\infrastructure\migrations;

use yii\db\Migration;

class m250412_133908_add_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_settings', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(1),
            'type' => $this->integer()->notNull()->comment('Тип настройки'),
            'value' => $this->string(),
            'entity_id' => $this->integer()->notNull()->comment('Указывает к какой сущности относится настройка'),
            'entity_type' => $this->integer()->notNull()->comment('Указывает к какому типу сущности относится настройка, т.к. в этой таблице хранится все настройки сущностей, а значит ид этих сущностей может пересекаться.'),
        ]);
        $schema = $this->db->schema->getTableSchema('user');
        if (!$schema) {
            $this->createTable('user', [
                'id' => $this->primaryKey(),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_settings');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250412_133908_add_table cannot be reverted.\n";

        return false;
    }
    */
}
