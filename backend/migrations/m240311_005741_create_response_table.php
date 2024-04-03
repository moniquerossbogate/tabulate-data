<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%response}}`.
 */
class m240311_005741_create_response_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%response}}', [
            'id' => $this->primaryKey(),
            'agency' => $this->string(128)->notNull(),
            'questionnaire_id' => $this->integer()->notNull(),
            'choices_id' => $this->integer()->notNull(),
            'merge_id' => $this->integer()->notNUll(),
            'response_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-response-questionnaire_id', '{{%response}}', 'questionnaire_id');
        $this->addForeignKey('fk-response-questionnaire_id', '{{%response}}', 'questionnaire_id', '{{%questionnaire}}', 'id', 'CASCADE');

        $this->createIndex('idx-response-choices_id', '{{%response}}', 'choices_id');
        $this->addForeignKey('fk-response-choices_id', '{{%response}}', 'choices_id', '{{%choices}}', 'id', 'CASCADE');

        $this->createIndex('idx-response-merge_id', '{{%response}}', 'merge_id');
        $this->addForeignKey('fk-response-merge_id', '{{%response}}', 'merge_id', '{{%merge}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-response-questionnaire_id', '{{%response}}');
        $this->dropIndex('idx-response-questionnaire_id', '{{%response}}');
        $this->dropForeignKey('fk-response-choices_id', '{{%response}}');
        $this->dropIndex('idx-response-choices_id', '{{%response}}');
        $this->dropForeignKey('fk-response-merge_id', '{{%response}}');
        $this->dropIndex('idx-response-merge_id', '{{%response}}');

        $this->dropTable('{{%response}}');
    }
}