<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "response".
 *
 * @property int $id
 * @property string $agency
 * @property int $questionnaire_id
 * @property int $choices_id
 * @property string $response_date
 *
 * @property Choices $choices
 * @property Questionnaire $questionnaire
 */
class Response extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['questionnaire_id'], 'required'],
            [['questionnaire_id', 'choices_id', 'merge_id'], 'integer'],
            [['response_date'], 'safe'],
            [['agency'], 'string', 'max' => 128],
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
            'agency' => 'Agency',
            'questionnaire_id' => 'Questionnaire ID',
            'choices_id' => 'Choices ID',
            'merge_id' => 'Merge ID',
            'response_date' => 'Response Date',

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

    /**
     * Gets query for [[Questionnaire]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaire()
    {
        return $this->hasOne(Questionnaire::class, ['id' => 'questionnaire_id']);
    }
    public function getMerge()
    {
        return $this->hasOne(Merge::class, ['id' => 'merge_id']);
    }
}