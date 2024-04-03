<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%merge}}`.
 */
class m240224_041311_create_merge_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%merge}}', [
            'id' => $this->primaryKey(),
            'choice_id' => $this->integer(),
            'question_id' => $this->integer(),
            'response_id' => $this->integer()
        ]);

        $this->createIndex('idx-merge-choice_id', '{{%merge}}', 'choice_id');
        $this->addForeignKey('fk-merge-choice_id', '{{%merge}}', 'choice_id', '{{%choices}}', 'id', 'SET NULL');

        $this->createIndex('idx-merge-question_id', '{{%merge}}', 'question_id');
        $this->addForeignKey('fk-merge-question_id', '{{%merge}}', 'question_id', '{{%questionaires}}', 'id', 'SET NULL');

        $this->createIndex('idx-merge-response_id', '{{%merge}}', 'response_id');
        $this->addForeignKey('fk-merge-response_id', '{{%merge}}', 'response_id', '{{%survey_response}}', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%merge}}');
    }
}
