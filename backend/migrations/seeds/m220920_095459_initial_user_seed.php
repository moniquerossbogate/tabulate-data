<?php

use app\models\SignupForm;
use app\models\User;
use yii\db\Migration;

/**
 * Class m220920_095459_initial_user_seed
 */
class m220920_095459_initial_user_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $form = new SignupForm();
        $form->username = 'DaVinziCode_21';
        $form->password = 'T@bulate2024';
        $form->firstname = 'super-admin';
        $form->lastname = 'admin';
        $form->email = 'admin@admin.com';
        return $form->signup();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220920_095459_initial_user_seed cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }
    
    public function down()
    {
        echo "m220920_095459_initial_user_seed cannot be reverted.\n";

        return false;
    }
    */
}
