<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "choices".
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property string $question_text
 * @property string $question_type
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Merge[] $merges
 * @property Questionnaire $questionnaire
 * @property Response[] $responses
 */
class Choices extends \yii\db\ActiveRecord
{
    const IS_PRIVATE = 1;
    const IS_PUBLIC = 0;
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
            [['questionnaire_id', 'id'], 'integer'],
            [['is_public'], 'boolean'],
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
            'questionnaire_id' => 'Title',
            'is_public' => 'Status',
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
}
