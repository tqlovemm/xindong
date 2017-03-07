<?php

namespace backend\modules\good\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\forum\models\AnecdoteThreads;

/**
 * AnecdoteThreadsSearch represents the model behind the search form about `frontend\modules\forum\models\AnecdoteThreads`.
 */
class AnecdoteThreadsSearch extends AnecdoteThreads
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tid', 'created_at', 'updated_at', 'thumbsup_count', 'thumbsdown_count', 'type', 'status'], 'integer'],
            [['user_id', 'content', 'linkurl'], 'safe'],
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
        $query = AnecdoteThreads::find()->where(['status'=>[2,4]]);

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
            'thumbsup_count' => $this->thumbsup_count,
            'thumbsdown_count' => $this->thumbsdown_count,
            'type' => $this->type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl]);

        return $dataProvider;
    }
}
