<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div class="row mt-2">
    <div class="col-md-12">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'firstname') ?>

        <?= $form->field($model, 'lastname') ?>

        <?= $form->field($model, 'middlename') ?>



        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!--.col-md-12-->
</div>