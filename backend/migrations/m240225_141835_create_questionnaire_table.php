<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%questionnaire}}`.
 */
class m240225_141835_create_questionnaire_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%questionnaire}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%questionnaire}}');
    }
}
