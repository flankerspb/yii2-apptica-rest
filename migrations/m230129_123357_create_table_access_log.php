<?php

use yii\db\Migration;

/**
 * Class m230129_123357_create_table_access_log
 */
class m230129_123357_create_table_access_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%access_log}}';

        $this->createTable($table, [
            'id'             => $this->primaryKey(),
            'request_time'   => $this->double(4)->notNull(),
            'user_ip'        => $this->string(39)->notNull(),
            'user_agent'     => $this->string()->notNull(),
            'request_method' => $this->string(7)->notNull(),
            'request_url'    => $this->string()->notNull(),
            'request_body'   => $this->string(),
            'status_code'    => $this->smallInteger()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230129_123357_create_table_access_log cannot be reverted.\n";

        return false;
    }
}
