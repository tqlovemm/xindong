<?php

namespace backend\modules\financial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\financial\models\FinancialWechatJoinRecord;

/**
 * FinancialWechatJoinRecordSearch represents the model behind the search form about `backend\modules\financial\models\FinancialWechatJoinRecord`.
 */
class FinancialWechatJoinRecordSearch extends FinancialWechatJoinRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'wechat_id', 'created_at', 'updated_at', 'day_time', 'weekly_time', 'mouth_time', 'created_by', 'payment_amount', 'vip', 'type'], 'integer'],
            [['join_source', 'channel', 'join_address', 'remarks'], 'safe'],
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
        $query = FinancialWechatJoinRecord::find();

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
            'wechat_id' => $this->wechat_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'day_time' => $this->day_time,
            'weekly_time' => $this->weekly_time,
            'mouth_time' => $this->mouth_time,
            'created_by' => $this->created_by,
            'payment_amount' => $this->payment_amount,
            'vip' => $this->vip,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'join_source', $this->join_source])
            ->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['like', 'join_address', $this->join_address])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
