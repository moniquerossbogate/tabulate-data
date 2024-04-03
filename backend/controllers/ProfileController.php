<?php

namespace app\controllers;

use app\models\UserProfile;
use app\models\UserChangePasswordForm;
use Yii;
use yii\bootstrap4\Alert;

class ProfileController extends \yii\web\Controller
{
    public function actionMyAccount()
    {
        $oldPassword = Yii::$app->user->identity->password;

        return $this->render('index');
    }

    public function actionChangePassword()
    {
        $user = new UserChangePasswordForm();
        $oldPassword = Yii::$app->user->identity->password;
        if ($this->request->isPost) {
            $oldPassword = Yii::$app->user->identity->password;
            $post = Yii::$app->request->post();
            $postOldPassword = $post['UserChangePasswordForm']['oldPassword'];
            $newPassword = $post['UserChangePasswordForm']['newPassword'];
            if (Yii::$app->security->validatePassword($postOldPassword, $oldPassword)) {
                $newPassHash = Yii::$app->security->generatePasswordHash($newPassword);
                $user->password = $newPassHash;
                $user->save();
            } else {
                $user->addError('oldPassword', 'Password incorrect.');
            }
        }

        return $this->render('change_password', [
            'user' => $user
        ]);
    }
}
