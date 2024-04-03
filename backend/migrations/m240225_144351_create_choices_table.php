<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%choices}}`.
 */
class m240225_144351_create_choices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%choices}}', [
            'id' => $this->primaryKey(),
            'questionnaire_id' => $this->integer()->notNull(),
            'question_text' => $this->text()->notNull(),
            'question_type' => "ENUM('A', 'B', 'C', 'D', 'E') NOT NULL",
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-choices-questionnaire_id', '{{%choices}}', 'questionnaire_id');
        $this->addForeignKey('fk-choices-questionnaire_id', '{{%choices}}', 'questionnaire_id', '{{%questionnaire}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-choices-questionnaire_id', '{{%choices}}');
        $this->dropIndex('idx-choices-questionnaire_id', '{{%choices}}');
        $this->dropTable('{{%choices}}');
    }
}
