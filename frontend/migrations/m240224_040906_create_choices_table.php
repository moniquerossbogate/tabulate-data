<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%choices}}`.
 */
class m240224_040906_create_choices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%choices}}', [
            'id' => $this->primaryKey(),
            'choice' => $this->string(100)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%choices}}');
    }
}
