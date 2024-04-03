<?php

namespace app\models;

use Yii;


class Personnel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personnel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_profile_id'], 'required'],
            [['user_profile_id'], 'integer'],
            [['user_profile_id'], 'unique'],
            [['user_profile_id'], 'unique', 'targetAttribute' => ['user_profile_id']],
            [['user_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['user_profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_profile_id' => 'User Profile ID',
        ];
    }



    /**
     * Gets query for [[UserProfile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'user_profile_id']);
    }
}
