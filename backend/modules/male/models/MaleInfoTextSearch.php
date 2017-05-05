<?php

namespace backend\modules\male\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\male\models\MaleInfoText;

/**
 * MaleInfoTextSearch represents the model behind the search form about `frontend\modules\male\models\MaleInfoText`.
 */
class MaleInfoTextSearch extends MaleInfoText
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'age', 'height', 'weight', 'marry', 'coin', 'vip', 'created_at', 'updated_at', 'status', 'created_by'], 'integer'],
            [['wechat', 'cellphone', 'email', 'car_type', 'annual_salary', 'job', 'offten_go', 'hobby', 'like_type', 'remarks', 'province', 'city', 'flag'], 'safe'],
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
        $query = MaleInfoText::find();

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
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'marry' => $this->marry,
            'coin' => $this->coin,
            'vip' => $this->vip,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'cellphone', $this->cellphone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'car_type', $this->car_type])
            ->andFilterWhere(['like', 'annual_salary', $this->annual_salary])
            ->andFilterWhere(['like', 'job', $this->job])
            ->andFilterWhere(['like', 'offten_go', $this->offten_go])
            ->andFilterWhere(['like', 'hobby', $this->hobby])
            ->andFilterWhere(['like', 'like_type', $this->like_type])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'flag', $this->flag]);

        return $dataProvider;
    }
}
