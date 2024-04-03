<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merge".
 *
 * @property int $id
 * @property int $choices_id
 * @property string $question_text
 * @property string $question_type
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
            [['choices_id', 'question_text', 'question_type'], 'required'],
            [['choices_id'], 'integer'],
            [['question_text', 'question_type'], 'string'],
            [['choices_id'], 'exist', 'skipOnError' => true, 'targetClass' => Choices::class, 'targetAttribute' => ['choices_id' => 'id']],
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
            'question_text' => 'Question Text',
            'question_type' => 'Question Type',
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
}
