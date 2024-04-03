<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m220914_023206_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull()->unique(),
            'user_profile_id' => $this->integer(),
            'status' => $this->integer(),
            'auth_token' => $this->string(255)->unique(),
            'access_token' => $this->string(255)->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-user-user_profile_id', '{{%user}}', 'user_profile_id');
        $this->addForeignKey('fk-user-user_profile_id', '{{%user}}', 'user_profile_id', '{{%user_profile}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user-user_profile_id', '{{%user}}');
        $this->dropIndex('idx-user-user_profile_id', '{{%user}}');

        $this->dropTable('{{%user}}');
    }
}
