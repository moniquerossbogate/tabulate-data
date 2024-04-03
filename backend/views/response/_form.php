<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Response $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="response-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'agency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'questionnaire_id')->textInput() ?>

    <?= $form->field($model, 'choices_id')->textInput() ?>

    <?= $form->field($model, 'merge_id')->textInput() ?>

    <?= $form->field($model, 'response_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
