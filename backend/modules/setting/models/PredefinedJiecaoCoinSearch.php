<?php

namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\setting\models\PredefinedJiecaoCoin;

/**
 * PredefinedJiecaoCoinSearch represents the model behind the search form about `backend\modules\setting\models\PredefinedJiecaoCoin`.
 */
class PredefinedJiecaoCoinSearch extends PredefinedJiecaoCoin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'money', 'giveaway', 'status','is_activity','member_type'], 'integer'],
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
        $query = PredefinedJiecaoCoin::find();

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
            'money' => $this->money,
            'giveaway' => $this->giveaway,
            'status' => $this->status,
            'is_activity' => $this->is_activity,
            'member_type' => $this->member_type,
        ]);

        return $dataProvider;
    }
}
