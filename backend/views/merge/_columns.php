<?php

use app\models\Merge;
use kartik\grid\GridView;
use yii\bootstrap4\Html;
use yii\helpers\Url;

return [

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'questionnaire_id',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'choices_id',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'question_text',
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
