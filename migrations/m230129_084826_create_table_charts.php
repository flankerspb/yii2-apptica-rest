<?php

use yii\db\Migration;

/**
 * Class m230129_084826_create_table_charts
 */
class m230129_084826_create_table_charts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%charts}}';

        $this->createTable($table, [
            'date'             => $this->date(),
            'country_id'       => $this->integer()->notNull(),
            'application_id'   => $this->integer()->notNull(),
            'root_category_id' => $this->integer()->notNull(),
            'category_id'      => $this->integer()->notNull(),
            'position'         => $this->integer(),
        ]);

        $this->addPrimaryKey(
            'pk-charts',
            $table,
            ['date', 'country_id', 'application_id', 'root_category_id', 'category_id']
        );

        $this->createIndex(
            'idx-charts-date',
            $table,
            'date'
        );

        $this->addForeignKey(
            'fk-charts-country_id',
            $table,
            'country_id',
            '{{%country}}',
            'id'
        );

        $this->addForeignKey(
            'fk-charts-application_id',
            $table,
            'application_id',
            '{{%application}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230129_084826_create_table_charts cannot be reverted.\n";

        return false;
    }
}
