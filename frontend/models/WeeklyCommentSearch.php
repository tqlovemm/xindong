<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * WeeklyCommentSearch represents the model behind the search form about `app\models\WeeklyComment`.
 */
class WeeklyCommentSearch extends WeeklyComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'weekly_id', 'created_at', 'user_id', 'status', 'likes'], 'integer'],
            [['content'], 'safe'],
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
        $query = WeeklyComment::find();

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
            'weekly_id' => $this->weekly_id,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'likes' => $this->likes,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
