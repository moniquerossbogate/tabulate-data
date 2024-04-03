<?php

namespace app\controllers;

class MyAccountController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
