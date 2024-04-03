<?php

use app\models\Questionnaire;
use kartik\switchinput\SwitchInput;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Choices $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="choices-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <?= $form->field($model, 'questionnaire_id')->dropDownList(
        ArrayHelper::map(Questionnaire::getQuestions(), 'id', 'title'),
        ['prompt' => 'Select a title...']
    ) ?>


    <div class="form-group">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper_component', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.component-item', // required: css class
            'limit' => 5, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-component', // css class
            'deleteButton' => '.remove-items', // css class
            'model' => $options[0],
            'formId' => 'dynamic-form',
            // 'formId' => 'form-equipment-setup',
            'formFields' => [
                'question_type',
                'question_text',

            ],
        ]);
        ?>

        <div class="container-items">
            <?php foreach ($options as $i => $option): ?>
                <div class="card card-info component-item w-100">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-pen"></i> Choices</h3>
                        <div class="card-tools">
                            <button type="button" class="remove-items btn btn-light btn-tool">Remove</button>
                            <button type="button" class="add-component btn btn-light btn-tool">Add</button>
                        </div>
                    </div>
                    <div class="card-body">

                        <?php
                        if (!$option->isNewRecord) {
                            echo Html::activeHiddenInput($option, "[{$i}]id");
                        } ?>
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($option, "[{$i}]question_type")->dropDownList([
                                    'A' => 'A',
                                    'B' => 'B',
                                    'C' => 'C',
                                    'D' => 'D',
                                    'E' => 'E',
                                ], ['prompt' => 'select type']) ?>
                            </div>
                            <div class="col-md-9">
                                <?= $form->field($option, "[{$i}]question_text")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>
    </div>



    <div class="float-right">
        <?= $form->field($model, 'is_public')->widget(SwitchInput::class, [
            // 'value' => true,
            'pluginOptions' => [
                'size' => 'small',
                'onText' => 'Private',
                'offText' => 'Public',
            ]
        ])->label(false) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>