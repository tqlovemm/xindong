<?php

namespace frontend\modules\forum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\forum\models\AnecdoteThreadComments;

/**
 * AnecdoteThreadCommentssSearch represents the model behind the search form about `frontend\modules\forum\models\AnecdoteThreadComments`.
 */
class AnecdoteThreadCommentssSearch extends AnecdoteThreadComments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'tid', 'created_at', 'updated_at', 'thumbsup_count', 'status'], 'integer'],
            [['user_id', 'comment'], 'safe'],
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
        $query = AnecdoteThreadComments::find();

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
            'cid' => $this->cid,
            'tid' => $this->tid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'thumbsup_count' => $this->thumbsup_count,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
