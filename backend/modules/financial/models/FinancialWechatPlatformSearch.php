<?php

namespace backend\modules\financial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\financial\models\FinancialWechatPlatform;

/**
 * FinancialWechatPlatformSearch represents the model behind the search form about `backend\modules\financial\models\FinancialWechatPlatform`.
 */
class FinancialWechatPlatformSearch extends FinancialWechatPlatform
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['platform_name', 'remarks'], 'safe'],
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
        $query = FinancialWechatPlatform::find();

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
        ]);

        $query->andFilterWhere(['like', 'platform_name', $this->platform_name])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
