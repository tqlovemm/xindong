<?php

namespace backend\modules\exciting\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WeeklyContentSearch represents the model behind the search form about `backend\modules\weekly\models\WeeklyContent`.
 */
class OtherTextPicSearch extends OtherTextPic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'tid', 'created_at', 'type', 'status'], 'integer'],
            [['name', 'content', 'pic_path'], 'safe'],
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
        $query = OtherTextPic::find();

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
            'id' => $this->pid,
            'tid' => $this->tid,
            'created_at' => $this->created_at,
            'type' => $this->type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'pic_path', $this->pic_path]);

        return $dataProvider;
    }
}
