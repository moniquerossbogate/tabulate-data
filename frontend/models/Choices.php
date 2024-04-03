<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "choices".
 *
 * @property int $id
 * @property int $questionnaire_id
 *
 * @property Merge[] $merges
 * @property Questionnaire $questionnaire
 * @property Response[] $responses
 */
class Choices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'choices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['questionnaire_id'], 'required'],
            [['questionnaire_id'], 'integer'],
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
            'questionnaire_id' => 'Questionnaire ID',
        ];
    }

    /**
     * Gets query for [[Merges]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMerges()
    {
        return $this->hasMany(Merge::class, ['choices_id' => 'id']);
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

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['choices_id' => 'id']);
    }

    public static function getProducts()
    {
        return self::find()->all();
    }
}
