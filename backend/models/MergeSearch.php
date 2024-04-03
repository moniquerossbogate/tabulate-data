<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Merge;

/**
 * MergeSearch represents the model behind the search form of `app\models\Merge`.
 */
class MergeSearch extends Merge
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'choices_id'], 'integer'],
            [['question_text', 'question_type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Merge::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'choices_id' => $this->choices_id,
        ]);

        $query->andFilterWhere(['like', 'question_text', $this->question_text])
            ->andFilterWhere(['like', 'question_type', $this->question_type]);

        return $dataProvider;
    }
}
