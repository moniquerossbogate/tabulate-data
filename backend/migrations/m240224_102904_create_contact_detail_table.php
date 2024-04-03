<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact_detail}}`.
 */
class m240224_102904_create_contact_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact_detail}}', [
            'id' => $this->primaryKey(),
            'user_profile_id' => $this->integer()->notNull(),
            'contact' => $this->string(62),
            'contact_type' => $this->integer(),
            'isActive' => $this->tinyInteger(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);
        $this->createIndex('idx-contact_detail-user_profile_id', '{{%contact_detail}}', 'user_profile_id');
        $this->addForeignKey('fk-contact_detail-user_profile_id', '{{%contact_detail}}', 'user_profile_id', '{{%user_profile}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-contact_detail-user_profile_id', '{{%contact_detail}}');
        $this->dropIndex('idx-contact_detail-user_profile_id', '{{%contact_detail}}');
        $this->dropTable('{{%contact_detail}}');
    }
}
