<?php

namespace backend\modules\recharge\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\recharge\models\AutoJoinPrice;

/**
 * AutoJoinPriceSearch represents the model behind the search form about `backend\modules\recharge\models\AutoJoinPrice`.
 */
class AutoJoinPriceSearch extends AutoJoinPrice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'member_sort', 'member_area', 'recharge_type', 'price', 'status'], 'integer'],
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
        $query = AutoJoinPrice::find();

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
            'member_sort' => $this->member_sort,
            'member_area' => $this->member_area,
            'recharge_type' => $this->recharge_type,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
