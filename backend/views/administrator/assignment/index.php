<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = '';
$this->params['breadcrumbs'][] = Yii::t('rbac-admin', 'Assignments');

$columns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'header' => '',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],
    [
        'attribute' => $usernameField,
    ],
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
    'class' => 'kartik\grid\ActionColumn',
    'dropdown' => false,
    'dropdownMenu' => ['class' => 'text-left'],
    'template' => '{view}',
    'buttons' => [
        'view' => function ($url, $model, $key) {
            return Html::a('Assign', $url, ['class' => 'btn btn-secondary btn-sm btn-block']);
        }
    ]
];

?>
<div class="assignment-index">
    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => true,
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_DARK,
            'heading' => '<i class="fas fa-address-book"></i> Assignments'
        ],
        'toolbar' => [
            '{toggleData}'
        ],
        'exportConfig' => [
            GridView::EXCEL => [],
            GridView::HTML => [],
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>