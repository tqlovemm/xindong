<?php

namespace backend\modules\note\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\note\models\VoteSignInfo;

/**
 * VoteSignInfoSearch represents the model behind the search form about `backend\modules\note\models\VoteSignInfo`.
 */
class VoteSignInfoSearch extends VoteSignInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sex', 'vote_count', 'created_at', 'updated_at', 'status'], 'integer'],
            [['openid', 'number', 'declaration', 'extra'], 'safe'],
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
        $query = VoteSignInfo::find()->where(['>','status',0])->orderBy('status asc');

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
            'vote_count' => $this->vote_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'declaration', $this->declaration])
            ->andFilterWhere(['like', 'extra', $this->extra]);

        return $dataProvider;
    }
}
