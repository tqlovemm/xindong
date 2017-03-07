<?php

namespace backend\modules\flop\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FlopContentSearch represents the model behind the search form about `backend\modules\flop\models\FlopContent`.
 */
class FlopContentSearch extends FlopContent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'flop_id', 'created_at', 'created_by', 'is_cover','other'], 'integer'],
            [['area', 'content','number', 'path', 'store_name','other'], 'safe'],
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
        $query = FlopContent::find();

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
            'flop_id' => $this->flop_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'is_cover' => $this->is_cover,
            'other' => $this->other,
        ]);

        $query->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'store_name', $this->store_name])
            ->andFilterWhere(['like', 'other', $this->other]);

        return $dataProvider;
    }
}
