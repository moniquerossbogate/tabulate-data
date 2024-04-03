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
        background-color: #ffffff;
        margin: 0 auto;
        font-family: sans-serif;
        padding: 0 40px;
        min-width: 240px;

    }

    h4 {
        text-align: center;
        color: gray;
    }

    .logo {
        text-align: center;
        padding-top: 90px;
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


        <center><h1>THANK YOU!</h1><center>


   

</body>

</html>