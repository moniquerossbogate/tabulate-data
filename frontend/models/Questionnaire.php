<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questionnaire".
 *
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Choices[] $choices
 * @property Response[] $responses
 */
class Questionnaire extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questionnaire';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Choices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChoices()
    {
        return $this->hasMany(Choices::class, ['questionnaire_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['questionnaire_id' => 'id']);
    }

    public static function getQuestions()
    {
        return self::find()->orderBy(['title' => SORT_ASC])->all();
    }
}
