<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'agency',
    ],
    [
        'attribute' => 'Questionnaire',
        'label' => 'Title',
        'value' => function ($model, $key, $index, $widget) {
            return $model->questionnaire->title;
        },
        'group' => true,

    ],
    [
        'attribute' => 'Choices',
        'label' => 'Choices',
        'value' => function ($model, $key, $index, $widget) {
            return $model->merge->question_type;
        },
    ],
    [
        'attribute' => 'Question',
        'label' => 'Question',
        'value' => function ($model, $key, $index, $widget) {
            return $model->merge->question_text;
        },


    ],


    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'response_date',
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
            'data-method' => false,
            // for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'
        ],
    ],

];