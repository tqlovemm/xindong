<?php

namespace backend\modules\local\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\local\models\LocalCollectionFilesText;

/**
 * LocalCollectionFilesTextSearch represents the model behind the search form about `backend\modules\local\models\LocalCollectionFilesText`.
 */
class LocalCollectionFilesTextSearch extends LocalCollectionFilesText
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'local', 'weichat', 'qq', 'cellphone', 'weibo', 'email', 'vip', 'address', 'job', 'hobby', 'car_type', 'like_type', 'extra', 'flag', 'often_go', 'annual_salary', 'weima'], 'safe'],
            [['birthday', 'sex', 'height', 'weight', 'marry', 'created_at', 'updated_at', 'status'], 'integer'],
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
        $query = LocalCollectionFilesText::find();

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
            'birthday' => $this->birthday,
            'sex' => $this->sex,
            'height' => $this->height,
            'weight' => $this->weight,
            'marry' => $this->marry,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'member_id', $this->member_id])
            ->andFilterWhere(['like', 'local', $this->local])
            ->andFilterWhere(['like', 'weichat', $this->weichat])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'cellphone', $this->cellphone])
            ->andFilterWhere(['like', 'weibo', $this->weibo])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'vip', $this->vip])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'job', $this->job])
            ->andFilterWhere(['like', 'hobby', $this->hobby])
            ->andFilterWhere(['like', 'car_type', $this->car_type])
            ->andFilterWhere(['like', 'like_type', $this->like_type])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'often_go', $this->often_go])
            ->andFilterWhere(['like', 'annual_salary', $this->annual_salary])
            ->andFilterWhere(['like', 'weima', $this->weima]);

        return $dataProvider;
    }
}
