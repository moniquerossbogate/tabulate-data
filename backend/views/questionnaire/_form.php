<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Questionnaire $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="questionnaire-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <?php ActiveForm::end(); ?>

</div>