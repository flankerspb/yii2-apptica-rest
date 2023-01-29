<?php

use yii\db\Migration;

/**
 * Class m230129_084736_create_table_country
 */
class m230129_084736_create_table_country extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%country}}';

        $this->createTable($table, [
            'id'          => $this->primaryKey(),
            'iso2'        => $this->char(2)->notNull(),
            'iso3'        => $this->char(3)->notNull(),
            'title'       => $this->string()->notNull(),
            'short_title' => $this->string()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230129_084736_create_table_country cannot be reverted.\n";

        return false;
    }
}
