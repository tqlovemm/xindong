<?php

namespace backend\modules\authentication\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\authentication\models\GirlAuthentication;

/**
 * GirlAuthenticationSearch represents the model behind the search form about `backend\modules\authentication\models\GirlAuthentication`.
 */
class GirlAuthenticationSearch extends GirlAuthentication
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id',  'updated_at', 'status'], 'integer'],
            [['video_url'], 'safe'],
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
        $query = GirlAuthentication::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'video_url', $this->video_url]);

        return $dataProvider;
    }
}
