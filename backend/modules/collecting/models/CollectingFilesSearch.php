<?php

namespace backend\modules\collecting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CollectingFilesText;

/**
 * Collecting17FilesSearch represents the model behind the search form about `backend\models\Collecting17FilesText`.
 */
class CollectingFilesSearch extends CollectingFilesText
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'age', 'sex', 'height', 'weight', 'gotofield', 'pay', 'qq', 'created_at', 'updated_at', 'status'], 'integer'],
            [['weichat', 'cellphone', 'address_province', 'address_city', 'address_detail', 'education', 'cup', 'job', 'job_detail', 'weibo', 'id_number', 'extra', 'flag'], 'safe'],
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
        $query = CollectingFilesText::find()->orderBy('id desc');

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
            'sex' => $this->sex,
            'height' => $this->height,
            'weight' => $this->weight,
            'gotofield' => $this->gotofield,
            'pay' => $this->pay,
            'qq' => $this->qq,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'weichat', $this->weichat])
            ->andFilterWhere(['like', 'cellphone', $this->cellphone])
            ->andFilterWhere(['like', 'address_province', $this->address_province])
            ->andFilterWhere(['like', 'address_city', $this->address_city])
            ->andFilterWhere(['like', 'address_detail', $this->address_detail])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'cup', $this->cup])
            ->andFilterWhere(['like', 'job', $this->job])
            ->andFilterWhere(['like', 'job_detail', $this->job_detail])
            ->andFilterWhere(['like', 'weibo', $this->weibo])
            ->andFilterWhere(['like', 'id_number', $this->id_number])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'flag', $this->flag]);

        return $dataProvider;
    }
}
