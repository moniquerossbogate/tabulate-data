<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%queue}}`.
 */
class m230202_052642_create_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%queue}}', [
            'id' => $this->primaryKey(),
            'channel' => $this->string()->notNull(),
            'job' => $this->binary()->notNull(),
            'pushed_at' => $this->integer()->notNull(),
            'ttr' => $this->integer()->notNull(),
            'delay' => $this->integer()->notNull(),
            'priority' => $this->integer()->unsigned()->notNull()->defaultValue(1024),
            'reserved_at' => $this->integer(),
            'attempt' => $this->integer(),
            'done_at' => $this->integer(),
        ]);

        $this->createIndex('idx-queue-channel', '{{%queue}}', 'channel');
        $this->createIndex('idx-queue-reserved_at', '{{%queue}}', 'reserved_at');
        $this->createIndex('idx-queue-priority', '{{%queue}}', 'priority');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%queue}}');
    }
}
