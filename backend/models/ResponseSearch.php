<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Response;

/**
 * ResponseSearch represents the model behind the search form about `app\models\Response`.
 */
class ResponseSearch extends Response
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'questionnaire_id', 'choices_id'], 'integer'],
            [['agency', 'response_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Response::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'questionnaire_id' => $this->questionnaire_id,
            'choices_id' => $this->choices_id,
            'response_date' => $this->response_date,
        ]);

        $query->andFilterWhere(['like', 'agency', $this->agency]);

        return $dataProvider;
    }
}