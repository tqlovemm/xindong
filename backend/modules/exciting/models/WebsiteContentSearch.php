<?php

namespace backend\modules\exciting\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WeeklyContentSearch represents the model behind the search form about `backend\modules\weekly\models\WeeklyContent`.
 */
class WebsiteContentSearch extends WebsiteContent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'website_id', 'created_at', 'created_by'], 'integer'],
            [['name', 'path',], 'safe'],
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
        $query = WebsiteContent::find();

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
            'website_id' => $this->website_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'path', $this->path]);
        return $dataProvider;
    }
}
