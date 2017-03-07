<?php

namespace backend\modules\recharge\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * RechargeContentSearch represents the model behind the search form about `backend\modules\weekly\models\RechargeContent`.
 */
class RechargeSearch extends Recharge
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['id','cover_id'], 'integer'],
            [['id', 'number', 'title'], 'string'],
            [['number', 'title','cover_id'], 'safe'],
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
        $query = Recharge::find()->where('status=2')->orderBy('updated_at DESC');

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
            'title' => $this->title,
            'cover_id' => $this->cover_id,
            'created_by' => $this->created_by,

        ]);

        $query->andFilterWhere(['like', 'number', $this->number]);


        return $dataProvider;
    }
}
