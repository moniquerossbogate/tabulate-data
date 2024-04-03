<?php

use yii\helpers\Html;
use yii\widgets\DetailView;



?>

<div class="modal-body">


    <?= DetailView::widget([
        'model' => $model,
        'id' => "myModal",
        'attributes' => [



            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'Title',
                'label' => 'Title',
                'value' => function ($model) {
                        return $model->questionnaire->title;
                    },
            ],

            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'Question',
                'label' => 'Question',
                'format' => 'raw',
                'value' => function ($model) {
                        $text = [];
                        foreach ($model->merges as $merge) {
                            $text[] = $merge->question_text;
                        }
                        return implode('<br> ', $text);
                    },
            ],
        ],
    ]) ?>


</div>