<?php

use app\models\Choices;
use kartik\grid\GridView;
use yii\bootstrap4\Html;
use yii\helpers\Url;


return [

    [
        'attribute' => 'Questionnaire',
        'label' => 'Title',
        'value' => function ($model, $key, $index, $widget) {
            return $model->questionnaire->title;
        },
        // 'group' => true,

    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'Choices',
        'label' => 'Choices',
        'format' => 'raw',
        'value' => function ($model, $key, $index, $widget) {
            $types = [];
            foreach ($model->merges as $merge) {
                $types[] = $merge->question_type;
            }
            return implode('<br> ', $types);
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'Question',
        'label' => 'Question',
        'format' => 'raw',
        'value' => function ($model, $key, $index, $widget) {
            $text = [];
            foreach ($model->merges as $merge) {
                $text[] = $merge->question_text;
            }
            return implode('<br> ', $text);
        },
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'is_public',
        'value' => function ($model) {
            if ($model->is_public == 1) {
                return 'Private';
            } else {
                return 'Public';
            }
        }
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
