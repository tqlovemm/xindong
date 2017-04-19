<?php

namespace backend\modules\financial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\financial\models\FinancialWechatMemberIncrease;

/**
 * FinancialWechatMemberIncreaseSearch represents the model behind the search form about `backend\modules\financial\models\FinancialWechatMemberIncrease`.
 */
class FinancialWechatMemberIncreaseSearch extends FinancialWechatMemberIncrease
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'wechat_id', 'total_count', 'increase_girl_count', 'increase_boy_count', 'reduce_count', 'created_at', 'updated_at', 'created_by', 'join_count'], 'integer'],
            [['loose_change'], 'number'],
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
        $query = FinancialWechatMemberIncrease::find();

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
            'increase_girl_count' => $this->increase_girl_count,
            'total_count' => $this->total_count,
            'increase_boy_count' => $this->increase_boy_count,
            'reduce_count' => $this->reduce_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'loose_change' => $this->loose_change,
            'join_count' => $this->join_count,
        ]);

        return $dataProvider;
    }
}
