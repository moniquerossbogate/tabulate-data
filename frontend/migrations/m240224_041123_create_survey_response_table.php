<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%survey_response}}`.
 */
class m240224_041123_create_survey_response_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%survey_response}}', [
            'id' => $this->primaryKey(),
            'agency' => $this->string(200),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%survey_response}}');
    }
}
