<?php

namespace backend\modules\collecting\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * AppFilesSearch represents the model behind the search form about `backend\modules\collecting\models\AppFiles`.
 */
class AppFilesSearch extends AppFiles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'age', 'sex', 'height', 'weight', 'marry', 'created_at', 'updated_at', 'status'], 'integer'],
            [['weichat', 'cellphone', 'weibo', 'address', 'job', 'hobby', 'like_type', 'car_type', 'extra', 'flag', 'often_go', 'annual_salary', 'qq'], 'safe'],
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
        $query = AppFiles::find();

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
            'cellphone' => $this->cellphone,
            'age' => $this->age,
            'sex' => $this->sex,
            'height' => $this->height,
            'weight' => $this->weight,
            'marry' => $this->marry,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'weichat', $this->weichat])
            ->andFilterWhere(['like', 'weibo', $this->weibo])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'job', $this->job])
            ->andFilterWhere(['like', 'hobby', $this->hobby])
            ->andFilterWhere(['like', 'like_type', $this->like_type])
            ->andFilterWhere(['like', 'car_type', $this->car_type])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'often_go', $this->often_go])
            ->andFilterWhere(['like', 'annual_salary', $this->annual_salary])
            ->andFilterWhere(['like', 'qq', $this->qq]);

        return $dataProvider;
    }
}
