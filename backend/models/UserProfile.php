<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string|null $middlename
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ContactDetail[] $contactDetails
 * @property User[] $users
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname',], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'middlename' => 'Middlename',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ContactDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContactDetails()
    {
        return $this->hasMany(ContactDetail::className(), ['user_profile_id' => 'id']);
    }


    /**
     * Gets query for [[Personnel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonnel()
    {
        return $this->hasOne(Personnel::className(), ['user_profile_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_profile_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_profile_id' => 'id']);
    }
}
