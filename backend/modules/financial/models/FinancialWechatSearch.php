<?php

namespace backend\modules\financial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\financial\models\FinancialWechat;

/**
 * FinancialWechatSearch represents the model behind the search form about `backend\modules\financial\models\FinancialWechat`.
 */
class FinancialWechatSearch extends FinancialWechat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'member_count', 'created_at', 'updated_at', 'created_by', 'status'], 'integer'],
            [['wechat', 'remarks', 'loose_change'], 'safe'],
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
        $query = FinancialWechat::find();

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
            'member_count' => $this->member_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'loose_change', $this->loose_change])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
