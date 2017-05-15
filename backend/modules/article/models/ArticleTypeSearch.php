<?php

namespace backend\modules\article\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\article\models\ArticleType;

/**
 * ArticleTypeSearch represents the model behind the search form about `backend\modules\article\models\ArticleType`.
 */
class ArticleTypeSearch extends ArticleType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tid', 'created_at', 'updated_at', 'status'], 'integer'],
            [['typename'], 'safe'],
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
        $query = ArticleType::find();

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
            'tid' => $this->tid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'typename', $this->typename]);

        return $dataProvider;
    }
}
