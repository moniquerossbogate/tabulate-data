<?php use hail812\adminlte\widgets\Menu;
use mdm\admin\components\Helper;
use mdm\admin\components\MenuHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$menuItems = [
    [
        'label' => 'Questionnaire',
        'url' => ['/questionnaire/index'],
        'icon' => 'question'
    ],
    [
        'label' => 'Choices',
        'url' => ['/choices/index'],
        'icon' => 'list'
    ],
    [
        'label' => 'Response',
        'url' => ['/response/index'],
        'icon' => 'list'
    ],

];

$userItems = [
    [
        'label' => 'Users Profile',
        'url' => ['/personnel/index'],
        'icon' => 'users'
    ],
];

$securityItems = [
    [
        'label' => 'Routes',
        'url' => ['/admin/route/'],
        'icon' => 'route'
    ],
    [
        'label' => 'Permissions',
        'url' => ['/admin/permission/'],
        'icon' => 'user-edit'
    ],
    [
        'label' => 'Assignments',
        'url' => ['/admin/assignment/'],
        'icon' => 'address-book'
    ],
    [
        'label' => 'Roles',
        'url' => ['/admin/role/'],
        'icon' => 'user-tag'
    ],

    // ['label' => 'Menu', 'url' => ['/admin/menu/'], 'icon' => 'bars'],

    [
        'label' => 'Rules',
        'url' => ['/admin/rule/'],
        'icon' => 'scroll'
    ],
];

$menuItems = Helper::filter($menuItems);
$userItems = Helper::filter($userItems);
$securityItems = Helper::filter($securityItems);
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/site/index" class="brand-link">
        <img src="/image/dost-logo1.png" alt="Logo" class="brand-image img-circle elevation-3"
            style="background-color: transparent;">
        <span class="brand-text font-weight-light">
            <?= Yii::$app->name ?>
        </span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?= Menu::widget([
                'items' => array_filter([
                    ...$menuItems,
                    count($userItems) > 0 ? ['label' => 'User Administration', 'header' => true] : null,
                    ...$userItems,
                    count($securityItems) > 0 ? ['label' => 'Security', 'header' => true] : null,
                    ...$securityItems
                ])
            ]);
            ?>
        </nav>
    </div>
</aside>