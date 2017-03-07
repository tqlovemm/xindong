<?php

namespace backend\modules\collecting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\collecting\models\AutoJoinRecord;

/**
 * AutoJoinRecordSearch represents the model behind the search form about `backend\modules\collecting\models\AutoJoinRecord`.
 */
class AutoJoinRecordSearch extends AutoJoinRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'member_sort', 'member_area', 'recharge_type', 'created_at', 'updated_at', 'status', 'price'], 'integer'],
            [['cellphone', 'extra', 'origin'], 'safe'],
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
        $query = AutoJoinRecord::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'origin' => $this->origin,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'cellphone', $this->cellphone])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'origin', $this->origin]);

        return $dataProvider;
    }
}
