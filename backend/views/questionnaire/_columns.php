<?php

use app\models\Questionnaire;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\Url;

return [


    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'title',
    ],
    [
        'attribute' => 'created_at',
        'headerOptions' => ['style' => 'color:#337ab7; text-align: center'],
        'value' => function ($model) {
            return Yii::$app->formatter->asDatetime(strtotime($model->created_at), 'php: d.M.Y h:i:a');
        },
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign' => 'middle',

        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => [
            'role' => 'modal-remote',
            'title' => 'Delete',
            'data-confirm' => false,
            'data-method' => false, // for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'
        ],
    ],

];
