<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merge".
 *
 * @property int $id
 * @property int $choices_id
 *
 * @property Choices $choices
 */
class Merge extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merge';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_type', 'question_text'], 'required'],
            [['choices_id', 'questionnaire_id'], 'integer'],
            [['choices_id'], 'exist', 'skipOnError' => true, 'targetClass' => Choices::class, 'targetAttribute' => ['choices_id' => 'id']],
            [['questionnaire_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questionnaire::class, 'targetAttribute' => ['questionnaire_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'choices_id' => 'Choices ID',
            'questionnaire_id' => 'Questions',
            'question_type' => 'Question Type',
            'question_text' => 'Question',
        ];
    }

    /**
     * Gets query for [[Choices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChoices()
    {
        return $this->hasOne(Choices::class, ['id' => 'choices_id']);
    }
    public function getQuestions()
    {
        return $this->hasOne(Questionnaire::class, ['id' => 'questionnaire_id']);
    }
}