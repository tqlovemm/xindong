<?php

namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\setting\models\AppPush;

/**
 * AppPushSearch represents the model behind the search form about `backend\modules\setting\models\AppPush`.
 */
class AppPushSearch extends AppPush
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['cid', 'title', 'msg', 'extras', 'platform', 'response'], 'safe'],
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
        $query = AppPush::find();

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'cid', $this->cid])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'msg', $this->msg])
            ->andFilterWhere(['like', 'extras', $this->extras])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'response', $this->response]);

        return $dataProvider;
    }
}
