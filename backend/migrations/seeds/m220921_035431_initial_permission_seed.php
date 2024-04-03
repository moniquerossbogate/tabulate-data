<?php

use app\models\User;
use mdm\admin\models\AuthItem;
use yii\db\Migration;
use yii\rbac\Item;

/**
 * Class m220921_035431_initial_permission_seed
 */
class m220921_035431_initial_permission_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $permissionNames = [
            'P-Admin-Admin__All' => [
                '/admin/*',
            ],
            // 'P-Tabulate__Admin' => [
            //     '/site/index',
            //     '/choices/index',
            //     '/choices/create',
            //     '/choices/update',
            //     '/choices/view',
            //     '/choices/delete',
            //     '/questionnaire/index',
            //     '/questionnaire/create',
            //     '/questionnaire/view',
            //     '/questionnaire/update',
            //     '/questionnaire/delete',
            // ],
            'P-User-Profile__View' => [
                '/user-profile/index',

            ],
            'P-User-Profile__Create' => [
                '/user-profile/signup',
                '/user-profile/toggle-status',

            ],
            'P-Personnel__View' => [
                '/personnel/index',
                '/personnel/view',

            ],
            'P-Personnel__Create' => [
                '/personnel/signup',
            ],
            'P-Personnel__Update' => [
                '/personnel/update-personnel',
            ],
            'P-Personnel__Delete' => [
                '/personnel/delete',
            ],
            'P-Route__Manage' => [
                // '/admin/route/*',
                '/admin/route/assign',
                '/admin/route/create',
                '/admin/route/index',
                '/admin/route/refresh',
                '/admin/route/remove',
            ],
            'P-Permission__Manage' => [
                // '/admin/permission/*',
                '/admin/permission/assign',
                '/admin/permission/create',
                '/admin/permission/delete',
                '/admin/permission/get-users',
                '/admin/permission/index',
                '/admin/permission/remove',
                '/admin/permission/update',
                '/admin/permission/view',
            ],
            'P-Role__Manage' => [
                // '/admin/role/*',
                '/admin/role/assign',
                '/admin/role/create',
                '/admin/role/delete',
                '/admin/role/get-users',
                '/admin/role/index',
                '/admin/role/remove',
                '/admin/role/update',
                '/admin/role/view',
            ],
            'P-Assignment__Manage' => [
                '/admin/assignment/*',
                '/admin/assignment/assign',
                '/admin/assignment/index',
                '/admin/assignment/revoke',
                '/admin/assignment/view',
            ],
        ];

        $auth = Yii::$app->authManager;

        foreach ($permissionNames as $key => $routes) {
            $adminPermission = $auth->createPermission($key);
            $adminPermission->description = '';
            $auth->add($adminPermission);

            foreach ($routes as $route) {
                $authItem = new AuthItem();
                $authItem->name = $route;
                $authItem->type = Item::TYPE_PERMISSION;

                $auth->addChild($adminPermission, $authItem);
            }

            // $user = User::findOne(['username' => 'super_admin2024']);
            // $auth->assign($adminPermission, $user->id);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220921_035431_initial_permission_seed cannot be reverted.\n";

        return false;
    }

/*
// Use up()/down() to run migration code without a transaction.
public function up()
{
}
public function down()
{
echo "m220921_035431_initial_permission_seed cannot be reverted.\n";
return false;
}
*/
}