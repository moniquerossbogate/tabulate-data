<?php

use app\models\User;
use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Profiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <!-- <p>
        <?= Html::a('Create User Profile', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '60px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                // uncomment below and comment detail if you need to render via ajax
                'detailUrl' => Url::to(['/user-profile/user-details']),
                // 'detail' => function ($model, $key, $index, $column) {
                //     return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
                // },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true,
                'enableRowClick' => true
            ],
            [
                'attribute' => 'firstname',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
            ],
            [
                'attribute' => 'middlename',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
            ],
            [
                'attribute' => 'lastname',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
            ],

            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $widget) {
                    $display = $model->user->status == User::STATUS_ACTIVE ? 'active' : 'inactive';
                    return Html::a($display, ['user-profile/toggle-status', 'id' => $model->id], ['data-method' => 'post', 'class' => 'btn btn-outline-secondary btn-sm btn-block status-toggle']);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    User::STATUS_ACTIVE => 'active',
                    User::STATUS_INACTIVE => 'inactive'
                ],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_CLASSIC,
                    'options' => [
                        'placeholder' => 'status',
                    ],
                    'pluginOptions' => ['allowClear' => true],
                    'size' => Select2::SMALL,
                    'hideSearch' => true,
                ],
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
            ],


        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => true,
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fas fa-users"></i> Users',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toolbar' => [
            [
                'content' => Html::a('<i class="fas fa-plus"></i>', ['signup'], ['class' => 'btn btn-sm btn-default', 'title' => 'Create User']) .
                    Html::a('<i class="fas fa-redo-alt"></i>', ['',], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
                //..Html::button('Create New <i class="fas fa-plus"></i>', ['class' => 'btn btn-sm btn-success open-equipment-create-modal'])
            ],
        ],
        'exportConfig' => [
            GridView::EXCEL => [],
            GridView::HTML => [],
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]); ?>


</div>

<?php
$this->registerJs(<<<JS
    $('body').on('mouseenter', '.status-toggle', (e) => {
        let btn = $(e.target);
        let status = btn.text();

        btn.text(status === 'active' ? 'deactivate' : 'activate');
    });

    $('body').on('mouseleave', '.status-toggle', (e) => {
        let btn = $(e.target);
        let status = btn.text();

        btn.text(status === 'activate' ? 'inactive' : 'active');
    });
JS, \yii\web\VIEW::POS_END);
