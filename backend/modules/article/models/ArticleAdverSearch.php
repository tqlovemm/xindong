<?php

namespace backend\modules\article\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\article\models\ArticleAdver;

/**
 * ArticleAdverSearch represents the model behind the search form about `backend\modules\article\models\ArticleAdver`.
 */
class ArticleAdverSearch extends ArticleAdver
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['thumb', 'url'], 'safe'],
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
        $query = ArticleAdver::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
