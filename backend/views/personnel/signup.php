<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use app\models\ContactDetail;
use app\models\Designation;
use kartik\select2\Select2;
use PHPUnit\Util\Log\JSON;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\web\View;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = ['label' => 'User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<style>
    .field-icon {
        float: right;
        margin-left: 10px;
        margin-top: 40px;
        position: relative;
        z-index: 1;
    }

    .container {
        padding-top: 50px;
        margin: auto;
    }
</style>
<div class="site-signup">

    <?php $form = ActiveForm::begin([
        'id' => 'form-signup',
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

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control form-control-sm']) ?>
                        </div>
                        <div class="col-5">
                            <?= $form->field($model, 'password')->passwordInput([
                                'class' => 'form-control form-control-sm',
                            ]) ?>

                        </div>
                        <span toggle="#signupform-password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <?= $form->field($model, 'firstname')->textInput(['class' => 'form-control form-control-sm']) ?>
                        </div>
                        <div class="col-4">
                            <?= $form->field($model, 'middlename')->textInput(['class' => 'form-control form-control-sm']) ?>
                        </div>
                        <div class="col-4">
                            <?= $form->field($model, 'lastname')->textInput(['class' => 'form-control form-control-sm']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'email')->input('email', ['class' => 'form-control form-control-sm']) ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $contacts[0],
                'formId' => 'form-signup',
                'formFields' => [
                    'contact_type',
                    'contact'
                ],
            ]); ?>

            <div class="card mb-1">
                <div class="card-header">
                    <span>
                        <span class="fas fa-address-card align-middle"></span> Contact Details
                        <button type="button" class="add-item btn btn-success btn-sm float-right"><i
                                class="fas fa-plus"></i> Add</button>
                    </span>
                </div>
                <div class="card-body">
                    <div class="container-items">
                        <?php foreach ($contacts as $i => $contact): ?>
                            <div class="item">

                                <div class="row">
                                    <div class="col-lg-5 col-md-12">
                                        <?php
                                        // necessary for update action.
                                        if (!$contact->isNewRecord) {
                                            echo Html::activeHiddenInput($contact, "[{$i}]id");
                                        }

                                        // echo $form->field($contact, "[{$i}]contact_type", [
                                        //     'template' => '<div class="row"><div class="col-3 text-right">{label}</div><div class="col-9">{input}{error}{hint}</div></div>',
                                    
                                        // ])->textInput(['class' => 'form-control form-control-sm'])->label('Type')
                                    
                                        echo $form->field($contact, "[{$i}]contact_type", [
                                            'template' => '<div class="row"><div class="col-3 text-right">{label}</div><div class="col-9">{input}{error}{hint}</div></div>'
                                        ])->dropdownList([
                                                    ContactDetail::TYPE_TELEPHONE => 'Telephone',
                                                    ContactDetail::TYPE_CELLPHONE => 'Cellphone',
                                                    ContactDetail::TYPE_EMAIL => 'Email'
                                                ], [
                                                    'value' => ContactDetail::TYPE_CELLPHONE,
                                                    'class' => 'form-control form-control-sm contact_field'
                                                ])
                                            ?>
                                    </div>
                                    <div class="col-lg-5 col-md-12">
                                        <?= $form->field($contact, "[{$i}]contact", [
                                            // 'enableClientValidation' => false,
                                            // 'enableAjaxValidation' => false,
                                            'template' => '<div class="row"><div class="col-3 text-right">{label}</div><div class="col-9">{input}{error}{hint}</div></div>',

                                        ])->textInput(['class' => 'form-control form-control-sm contact_input']) ?>
                                    </div>
                                    <div class="col-lg-2 col-md-12">
                                        <button type="button"
                                            class="remove-item btn btn-danger btn-sm btn-block mb-1">Remove</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-block', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJs(
    <<<JS
    const TYPE_TELEPHONE = 1;
    const TYPE_CELLPHONE = 2;
    const TYPE_EMAIL = 3;

    const selectEvent = (event) => {
        alert(event.currentTarget.index);
    };

    $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
        
    });

    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        $('.contact_field:last').on('change', function () {
            let contact_type = $(this).val();

            if(contact_type == TYPE_TELEPHONE)
                console.log('telephone');
            else if(contact_type == TYPE_CELLPHONE)
                console.log('cellphone');
            else
                console.log('email');
            //$(this).closest('.item').find('.contact_input').attr('type', 'email');
        });
    });

    // $('#form-signup').closest('.dynamicform_wrapper').on("afterInsert", function(e, item) {
    //     console.log('Test');
    // });

    $(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
        // if (! confirm("Are you sure you want to delete this item?")) {
        //     return false;
        // }
        // return true;
    });

    $(".dynamicform_wrapper").on("afterDelete", function(e) {
        console.log("Deleted item!");
    });

    $(".dynamicform_wrapper").on("limitReached", function(e, item) {
        alert("Limit reached");
    });

    //for password toggle
   $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
    });


JS,
    View::POS_READY
);
