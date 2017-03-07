<?php

namespace backend\modules\exciting\models;

use frontend\modules\weixin\models\FirefightersSignUp;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * FirefightersSignUpSearch represents the model behind the search form about `backend\modules\exciting\models\FirefightersSignUp`.
 */
class FirefightersSignUpSearch extends FirefightersSignUp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'sign_id', 'created_at', 'status'], 'integer'],
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
        $query = FirefightersSignUp::find();

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
            'sign_id' => $this->sign_id,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
