<?php

namespace frontend\modules\forum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\forum\models\AnecdoteThreadCommentComments;

/**
 * AnecdoteThreadCommentCommentsSearch represents the model behind the search form about `frontend\modules\forum\models\AnecdoteThreadCommentComments`.
 */
class AnecdoteThreadCommentCommentsSearch extends AnecdoteThreadCommentComments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ccid', 'cid', 'created_at', 'status'], 'integer'],
            [['user_id', 'to_user_id', 'content'], 'safe'],
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
        $query = AnecdoteThreadCommentComments::find();

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
            'ccid' => $this->ccid,
            'cid' => $this->cid,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'to_user_id', $this->to_user_id])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
