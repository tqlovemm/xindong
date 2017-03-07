<?php

namespace backend\modules\app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\app\models\AppOrderList;

/**
 * AppOrderListSearch represents the model behind the search form about `backend\modules\app\models\AppOrderList`.
 */
class AppOrderListSearch extends AppOrderList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'giveaway', 'type', 'status', 'updated_at',], 'integer'],
            [['order_number', 'alipay_order', 'extra', 'channel', 'description'], 'safe'],
            [['total_fee'], 'number'],
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
        $query = AppOrderList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  =>  [
                'defaultOrder'   => [
                    'id'    =>  SORT_DESC,
                    'updated_at'    =>  SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_fee' => $this->total_fee,
            'giveaway' => $this->giveaway,
            'type' => $this->type,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'alipay_order', $this->alipay_order])
            //->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
