<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seed_migration}}`.
 */
class m220920_234926_create_seed_migration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%seed_migration}}', [
            'version' => $this->string(180)->notNull(),
            'apply_time' => $this->integer()
        ]);

        $this->createIndex('idx-seed_migration-version', '{{%seed_migration}}', 'version', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-seed_migration-version', '{{%seed_migration}}');
        $this->dropTable('{{%seed_migration}}');
    }
}
