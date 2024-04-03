<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact_detail".
 *
 * @property int $id
 * @property int $user_profile_id
 * @property string|null $contact
 * @property int|null $contact_type
 * @property int|null $isActive
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserProfile $userProfile
 */
class ContactDetail extends \yii\db\ActiveRecord
{
    const TYPE_TELEPHONE = 1;
    const TYPE_CELLPHONE = 2;
    const TYPE_EMAIL = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact'], 'safe'],
            [['user_profile_id', 'contact_type', 'isActive'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['contact'], 'string', 'max' => 62],
            [['user_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['user_profile_id' => 'id']],

            // ['contact', 'email', 'when' => function ($model) {
            //     return $model->contact_type == self::TYPE_EMAIL;
            // }]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_profile_id' => 'User Profile ID',
            'contact' => 'Contact',
            'contact_type' => 'Type',
            'isActive' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
