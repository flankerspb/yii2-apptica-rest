<?php

use yii\db\Migration;

/**
 * Class m230129_084743_create_table_developer
 */
class m230129_084743_create_table_developer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%developer}}';

        $this->createTable($table, [
            'id'            => $this->primaryKey(),
            'title'         => $this->string()->notNull(),
            'short_title'   => $this->string()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230129_084743_create_table_developer cannot be reverted.\n";

        return false;
    }
}
