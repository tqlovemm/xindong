<?php

namespace backend\modules\seek\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\member\models\AlipayCoinRechargeRecord;

/**
 * AlipayCoinRechargeRecordSearch represents the model behind the search form about `frontend\modules\member\models\AlipayCoinRechargeRecord`.
 */
class AlipayCoinRechargeRecordSearch extends AlipayCoinRechargeRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'giveaway', 'day_time', 'week_time', 'mouth_time', 'type', 'status', 'platform'], 'integer'],
            [['user_number', 'out_trade_no', 'subject', 'notify_time', 'extra', 'description'], 'safe'],
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
        $query = AlipayCoinRechargeRecord::find()->orderBy('notify_time desc');

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
            'user_id' => $this->user_id,
            'total_fee' => $this->total_fee,
            'giveaway' => $this->giveaway,
            'day_time' => $this->day_time,
            'week_time' => $this->week_time,
            'mouth_time' => $this->mouth_time,
            'type' => $this->type,
            'status' => $this->status,
            'platform' => $this->platform,
        ]);

        $query->andFilterWhere(['like', 'user_number', $this->user_number])
            ->andFilterWhere(['like', 'out_trade_no', $this->out_trade_no])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'notify_time', $this->notify_time])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
