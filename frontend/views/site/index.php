<?php

// ... other use statements ...

use yii\helpers\Url;
use yii\widgets\ActiveForm; // Add this line to import ActiveForm
use app\models\Choices;
use app\models\Merge;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var app\models\Questionnaire $model */
/** @var yii\widgets\ActiveForm $form */
?>
<!DOCTYPE html>
<html lang="en">
<style>
    * {
        box-sizing: border-box;
    }

    .regForm {
        background-color: black;
        color: white;
        margin: 0 auto;
        font-family: sans-serif;
        padding: 0 40px;
        min-width: 240px;

    }

    h4 {
        text-align: center;
        color: white;
    }

    .logo {
        text-align: center;
        padding-top: 100px;
    }

    img {
        width: 170px;
        height: 170px;
    }

    #myAni {
        animation: myAni 3s ease 0.5s infinite alternate;
    }

    #greetings {
        text-align: center;
        color: gray;
        font-weight: 600;
        padding-top: 35px;
    }

    @keyframes myAni {
        0% {
            opacity: 1;

        }

        50% {
            opacity: 0;


        }

        100% {
            opacity: 1;

        }
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/3f22f7edc5.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<body>
    
    <div class="logo"><img src="../images/logo.png" alt="logo"></div>
    <div class="regForm" id="mainContent" onsubmit="return validationForm()">
        <?php $form = ActiveForm::begin(
            [   
                'id' => 'dynamic-form',
                'action' => ['create'],
                'options' => ['data-pjax' => false],
            ]
        ); ?>

        <div class="tab">
            <?= Html::hiddenInput('selected_values', null, ['id' => 'selected_values']) ?>

            <div>
                <p>
                    <?php if (!empty($titles) && ($public)) : ?>
                <div class="portfolio-description">
                    <h4>Question: <i class="fa-sharp fa-solid fa-circle-question" id="myAni"></i></h4>
                    <?php foreach ($titles as $title) : ?>
                        <?php if ($title->is_public == 0) : ?>
                            <br>
                            <p><?= $title->questionnaire->title ?></p>
                            <br>
                            <?php
                                $group = Merge::find()->where(['choices_id' => $title['id']])->all();
                                foreach ($group as $single) :
                            ?>
                                <div class="radio">
                                    <input id="service_check<?= $single['id'] ?>" name="radio" class="cb-services" type="radio" value="<?= $single['id'] ?>"> &nbsp;&nbsp;
                                    <label for="service_check<?= $single['id'] ?>" class="radio-label"><?= $single->question_text ?></label>
                                </div><br>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                </p>
                <?= $form->field($model, 'agency')->textInput(['maxlength' => true, 'placeholder' => 'Name(optional)'])->label('Agency:') ?>
            </div>

            <div class="form-group pull-left" style="padding-top:10px; margin-left: 8px;">
                <?= Html::submitButton('Submit', [
                            'class' => 'btn btn-primary disabled',
                            'id' => 'service_button',
                            'disabled' => true,
                        ]) ?>
            </div>
        </div>

    <?php endif; ?>
    <?php ActiveForm::end(); ?>
    </div>


    <script>
        $(function() {
            $(".cb-services").on('change', function() {
                var st = $('.cb-services:checked').length;
                if (st > 0) {
                    $('#service_button').prop("disabled", false).removeClass('disabled');
                } else {
                    $('#service_button').prop("disabled", true).addClass('disabled');
                }
            });

            $('#dynamic-form').on('submit', function() {
                let selected_cb = $("input[name='radio']:checked").val();
                $('#selected_values').val(selected_cb);
                return true;
            });
        });


      //  function validationForm() {
        //    if (window.confirm("Are you sure to submit this form?")) {
          //      document.getElementById("mainContent").style.display = "none";

                // Swal.fire({
                //     title: "Submitted Successfully!",
                //     icon: "success",
                //     showConfirmButton: false,
                //     timer: 3000
                // },
            // );
            
            
            //return true;
            //} else {
              //  document.getElementById("mainContent").style.display = "block";
                //return false;
            //}
        //};
    </script>

</body>

</html>