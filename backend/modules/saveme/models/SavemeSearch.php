<?php

namespace backend\modules\saveme\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\saveme\models\Saveme;

/**
 * SavemeSearch represents the model behind the search form about `backend\modules\saveme\models\Saveme`.
 */
class SavemeSearch extends Saveme
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_id', 'price', 'created_at', 'updated_at', 'end_time', 'status'], 'integer'],
            [['address', 'content'], 'safe'],
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
        $query = Saveme::find();

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
            'created_id' => $this->created_id,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'end_time' => $this->end_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
