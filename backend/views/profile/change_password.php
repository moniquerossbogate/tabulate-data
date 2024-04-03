<?php

use yii\bootstrap4\ActiveForm;



?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Change Password</h3>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'form-change-password',
        'action' => 'change-password',
        'method' => 'POST',
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]);
    ?>
    <div class="card-body">
        <div class="form-group">

            <?= $form->field($user, 'oldPassword')->textInput(['maxlength' => true, 'class' => 'form-control', 'type' => 'password']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($user, 'newPassword')->textInput(['maxlength' => true, 'class' => 'form-control', 'type' => 'password']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($user, 'confirmNewPassword')->textInput(['maxlength' => true, 'class' => 'form-control', 'type' => 'password']) ?>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" fdprocessedid="50cd5g">Submit</button>
    </div>
    <?php ActiveForm::end(); ?>


</div>