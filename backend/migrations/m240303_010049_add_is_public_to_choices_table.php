<?php

use yii\db\Migration;

/**
 * Class m240303_010049_add_is_public_to_choices_table
 */
class m240303_010049_add_is_public_to_choices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%choices}}', 'is_public', $this->boolean()->defaultValue(true)->after('questionnaire_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%choices}}', 'is_public');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240303_010049_add_is_public_to_choices_table cannot be reverted.\n";

        return false;
    }
    */
}
