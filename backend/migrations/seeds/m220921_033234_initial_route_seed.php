<?php

use mdm\admin\models\Route;
use yii\db\Migration;

/**
 * Class m220921_033234_initial_route_seed
 */
class m220921_033234_initial_route_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $route = new Route();
        $route->addNew([
            '/admin/*',
            '/site/index',
            '/user-profile/index',
            '/user-profile/signup',
            '/user-profile/toggle-status',
            '/personnel/index',
            '/personnel/view',
            '/personnel/signup',
            '/personnel/update-personnel',
            '/personnel/delete',
            '/questionnaire/index',
            '/questionnaire/view',
            '/questionnaire/update',
            '/questionnaire/delete',
            '/choices/index',
            '/choices/view',
            '/choices/update',
            '/choices/delete',
            '/admin/route/assign',
            '/admin/route/create',
            '/admin/route/index',
            '/admin/route/refresh',
            '/admin/route/remove',
            '/admin/permission/assign',
            '/admin/permission/create',
            '/admin/permission/delete',
            '/admin/permission/get-users',
            '/admin/permission/index',
            '/admin/permission/remove',
            '/admin/permission/update',
            '/admin/permission/view',
            '/admin/role/assign',
            '/admin/role/create',
            '/admin/role/delete',
            '/admin/role/get-users',
            '/admin/role/index',
            '/admin/role/remove',
            '/admin/role/update',
            '/admin/role/view',
            '/admin/assignment/*',
            '/admin/assignment/assign',
            '/admin/assignment/index',
            '/admin/assignment/revoke',
            '/admin/assignment/view',

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220921_033234_initial_route_seed cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220921_033234_initial_route_seed cannot be reverted.\n";

        return false;
    }
    */
}
