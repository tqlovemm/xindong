<?php

namespace backend\modules\good\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CheckServiceSearch represents the model behind the search form about `backend\modules\good\models\CheckService`.
 */
class CheckServiceSearch extends CheckService
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'flag', 'created_at', 'updated_at'], 'integer'],
            [['number','avatar','nickname'],'string'],
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
        $query = CheckService::find();

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
            'flag' => $this->flag,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'number', $this->number])
                ->andFilterWhere(['like', 'avatar', $this->number])
                ->andFilterWhere(['like', 'nickname', $this->number]);

        return $dataProvider;
    }
}
