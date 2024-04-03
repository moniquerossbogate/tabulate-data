<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%merge}}`.
 */
class m240302_034444_create_merge_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%merge}}', [
            'id' => $this->primaryKey(),
            'choices_id' => $this->integer()->notNull(),
            'question_text' => $this->text()->notNull(),
            'question_type' => "ENUM('A', 'B', 'C', 'D', 'E') NOT NULL",
        ]);

        $this->createIndex('idx-merge-choices_id', '{{%merge}}', 'choices_id');
        $this->addForeignKey('fk-merge-choices_id', '{{%merge}}', 'choices_id', '{{%choices}}', 'id', 'CASCADE');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-merge-choices_id', '{{%merge}}');
        $this->dropIndex('idx-merge-choices_id', '{{%merge}}');
        $this->dropTable('{{%merge}}');
    }
}

