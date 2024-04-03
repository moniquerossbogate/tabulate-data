<?php

use app\models\Equipment;
use app\models\EquipmentCategory;
use app\models\EquipmentType;
use app\models\ProcessingCapability;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\ContactDetail;
use app\models\Designation;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\Pjax;
use yii\web\View;


?>
<?php Modal::begin([
    'id' => 'modal-create-user',
    'title' => 'Add User',
    'size' => 'modal-lg',
    // 'toggleButton' => [
    //     'label' => 'Create Facility',
    //     'class' => 'btn btn-success btn-sm'
    // ],
]); ?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-signup',
        'action' => 'signup',
        'options' => [],
        'method' => 'POST',
        'layout' => 'default',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'offset-sm-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ]
        ]

    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'firstname')->textInput(['class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'middlename')->textInput(['class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'lastname')->textInput(['class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'email')->input('email', ['class' => 'form-control form-control-sm']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>



    <?php Modal::end();


    $this->registerJs(<<<JS
    $('#form-signup').on('beforeSubmit', function() {
        let yiiform = $(this);
        // console.log(yiiform.yiiActiveForm('find', 'equipment-imagefile').value);
        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray(),
            
        }).done(data => {
            if(data.success){
                $('#modal-create-user').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                               //..resets form
                swal({
                    title: 'Sucess',
                    text: 'Facility successfully created!',
                    type: "success"
                });
                $.pjax.reload({container:'#userGrid'}); //..reload gridview
            } else if (data.validation) {
                yiiform.yiiActiveForm('updateMessages', data.validation, true);
            } else {
                // incorrect server response
            }
        }).fail(() => {
            // request failed
        });

        return false;
    });
JS);
