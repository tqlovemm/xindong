<?php

namespace backend\modules\bgadmin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\bgadmin\models\ScanWeimaDetail;

/**
 * ScanWeimaDetailSearch represents the model behind the search form about `backend\modules\bgadmin\models\ScanWeimaDetail`.
 */
class ScanWeimaDetailSearch extends ScanWeimaDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sence_id'], 'integer'],
            [['customer_service', 'account_manager', 'description'], 'safe'],
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
        $query = ScanWeimaDetail::find();

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
            'sence_id' => $this->sence_id,
        ]);

        $query->andFilterWhere(['like', 'customer_service', $this->customer_service])
            ->andFilterWhere(['like', 'account_manager', $this->account_manager])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
