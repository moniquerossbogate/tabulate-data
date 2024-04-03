<?php

use app\models\Designation;
use app\models\UserProfile;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<?php Modal::begin([
    'id' => '_create_personnel',
    'title' => 'Sign Up',
    'size' => 'modal-md',
]); ?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create',
        'options' => [
            'enctype' => 'multipart/form-data',
        ]
    ]) ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control form-control-sm']) ?>

    <?= $form->field($model, 'password')->passwordInput([
        'class' => 'form-control form-control-sm ',

    ])

        ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php Modal::end();
