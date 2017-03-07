<?php

namespace backend\modules\flop\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\dating\models\Dating;

/**
 * DatingBgSearch represents the model behind the search form about `backend\modules\dating\models\Dating`.
 */
class DatingBgSearch extends Dating
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cover_id', 'created_at', 'updated_at', 'created_by', 'enable_comment', 'status', 'worth', 'expire', 'full_time', 'platform'], 'integer'],
            [['title', 'title2', 'title3', 'content', 'introduction', 'url', 'number', 'avatar', 'flag'], 'safe'],
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
        $query = Dating::find()->where(['status'=>2,'cover_id'=>-2])->orderBy("created_at desc");

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
            'cover_id' => $this->cover_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'enable_comment' => $this->enable_comment,
            'status' => $this->status,
            'worth' => $this->worth,
            'expire' => $this->expire,
            'full_time' => $this->full_time,
            'platform' => $this->platform,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title2', $this->title2])
            ->andFilterWhere(['like', 'title3', $this->title3])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'flag', $this->flag]);

        return $dataProvider;
    }
}
