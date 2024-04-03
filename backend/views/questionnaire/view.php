<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>

<div class="modal-body">


    <?= DetailView::widget([
        'model' => $model,
        'id' => "myModal",
        'attributes' => [

            'title',
            'created_at',
            'updated_at',
        ],
    ]) ?>


</div>