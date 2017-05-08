<?php

namespace backend\modules\article\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\article\models\article;

/**
 * ArticleSearch represents the model behind the search form about `backend\modules\article\models\article`.
 */
class ArticleSearch extends article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_id', 'wtype', 'wclick', 'wdianzan', 'hot', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'wimg', 'content'], 'safe'],
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
        $query = article::find();

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
            'created_id' => $this->created_id,
            'wtype' => $this->wtype,
            'wclick' => $this->wclick,
            'wdianzan' => $this->wdianzan,
            'hot' => $this->hot,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'wimg', $this->wimg])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
