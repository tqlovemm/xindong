<?php

namespace backend\modules\active\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\active\models\NewYear;

/**
 * NewYearSearch represents the model behind the search form about `backend\modules\active\models\NewYear`.
 */
class NewYearSearch extends NewYear
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sex', 'num', 'status',], 'integer'],
            [['enounce', 'openId', 'plateId'], 'safe'],
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
        $query = NewYear::find();

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
            'sex' => $this->sex,
            'num' => $this->num,
            'status' => $this->status,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'enounce', $this->enounce])
            ->andFilterWhere(['like', 'openId', $this->openId])
            ->andFilterWhere(['like', 'plateId', $this->plateId]);

        return $dataProvider;
    }
}
