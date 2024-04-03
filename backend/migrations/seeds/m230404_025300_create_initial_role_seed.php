<?php

use app\models\User;
use mdm\admin\models\AuthItem;
use yii\db\Migration;
use yii\rbac\Item;

/**
 * Class m230404_025300_create_initial_role_seed
 */
class m230404_025300_create_initial_role_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $roleNames = [
            'R-Security__Admin' => [
                'P-Route__Manage',
                'P-Permission__Manage',
                'P-Role__Manage',
                'P-Assignment__Manage'
            ],
            'R-User__Admin' => [
                // 'P-User-Profile__View',
                // 'P-User-Profile__Create',
                'P-Personnel__View',
                'P-Personnel__Create',
                'P-Personnel__Update',
                'P-Personnel__Delete',
            ],
            // 'R-Tabulate__Admin' => [
            //     'P-Choices__Index',
            //     'P-Choices__Create',
            //     'P-Choices__View',
            //     'P-Choices__Update',
            //     'P-Choices__Delete',
            //     'P-Questionnaire__Index',
            //     'P-Questionnaire__View',
            //     'P-Questionnaire__Create',
            //     'P-Questionnaire__Update',
            //     'P-Questionnaire__Delete',

            // ],

        ];

        $auth = Yii::$app->authManager;

        foreach ($roleNames as $key => $permissions) {
            $adminRole = $auth->createRole($key);
            $adminRole->description = '';
            $auth->add($adminRole);

            foreach ($permissions as $permission) {
                $authItem = new AuthItem();
                $authItem->name = $permission;
                $authItem->type = Item::TYPE_ROLE;

                $auth->addChild($adminRole, $authItem);
            }

            $user = User::findOne(['username' => 'DaVinziCode_21']);
            $auth->assign($adminRole, $user->id);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230404_025300_create_initial_role_seed cannot be reverted.\n";

        return false;
    }

/*
// Use up()/down() to run migration code without a transaction.
public function up()
{
}
public function down()
{
echo "m230404_025300_create_initial_role_seed cannot be reverted.\n";
return false;
}
*/
}