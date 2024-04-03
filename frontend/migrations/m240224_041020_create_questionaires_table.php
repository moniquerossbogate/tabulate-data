<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%questionaires}}`.
 */
class m240224_041020_create_questionaires_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%questionaires}}', [
            'id' => $this->primaryKey(),
            'question' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%questionaires}}');
    }
}
