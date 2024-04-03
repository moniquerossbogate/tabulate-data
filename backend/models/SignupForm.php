<?php

namespace app\models;

use Exception;
use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $_id;
    public $username;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $middlename;


    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 8, 'max' => 255],
            ['username', 'match', 'pattern' => '/^(?=.*\d.*\d)[a-zA-Z\d_]+$/', 'message' => 'Username must contain at least two numbers'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This username has already been taken.'],



            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 4],

            [['firstname', 'lastname'], 'trim'],
            [['firstname', 'lastname'], 'required'],
            [['firstname', 'lastname'], 'string', 'max' => 32],

            [['middlename'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        $testError = $this->errors;
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        $user = new User();

        $profile = new UserProfile();
        $profile->firstname = $this->firstname;
        $profile->lastname = $this->lastname;
        $profile->middlename = $this->middlename;


        try {
            if ($profile->save()) {
                $this->_id = $profile->id;
                $user->username = $this->username;
                $user->email = $this->email;
                $user->user_profile_id = $profile->id;
                $user->setPassword($this->password);
                $user->generateAuthKey();

                $user->save();
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
    public function updateProfile()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = Yii::$app->db->beginTransaction();

        $user = new User();

        $profile = new UserProfile();
        $profile->firstname = $this->firstname;
        $profile->lastname = $this->lastname;
        $profile->middlename = $this->middlename;

        try {
            if ($profile->save()) {
                $this->_id = $profile->id;
                $user->username = $this->username;
                $user->email = $this->email;
                $user->user_profile_id = $profile->id;
                $user->setPassword($this->password);
                $user->generateAuthKey();

                $user->save();
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}
