<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_profile}}`.
 */
class m220914_022538_create_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(32)->notNull(),
            'lastname' => $this->string(32)->notNull(),
            'middlename' => $this->string(32),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_profile}}');
    }
}
