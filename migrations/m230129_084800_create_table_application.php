<?php

use yii\db\Migration;

/**
 * Class m230129_084800_create_table_application
 */
class m230129_084800_create_table_application extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%application}}';

        $this->createTable($table, [
            'id'            => $this->primaryKey(),
            'title'         => $this->string()->notNull(),
            'short_title'   => $this->string()->notNull(),
            'googleplay_id' => $this->string()->notNull(),
            'appstore_id'   => $this->integer()->notNull(),
            'developer_id'  => $this->integer()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-application-developer_id',
            $table,
            'developer_id',
            '{{%developer}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230129_084800_create_table_application cannot be reverted.\n";

        return false;
    }
}
