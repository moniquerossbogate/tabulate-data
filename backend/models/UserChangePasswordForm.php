<?php

namespace app\models;

use Yii;

class UserChangePasswordForm extends User
{
    public $oldPassword;
    public $newPassword;
    public $confirmNewPassword;


    public function rules()
    {
        return [
            ['newPassword', 'match', 'pattern' => '/^(?=.*\d.*\d)[a-zA-Z\d_]+$/', 'message' => 'Username must contain at least two numbers'],
            ['confirmNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Password does not match']

        ];
    }
}
