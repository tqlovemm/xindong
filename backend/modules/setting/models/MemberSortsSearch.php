<?php

namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\setting\models\MemberSorts;

/**
 * MemberSortsSearch represents the model behind the search form about `backend\modules\setting\models\MemberSorts`.
 */
class MemberSortsSearch extends MemberSorts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price_1','price_2','price_3'], 'integer'],
            [['member_name', 'member_introduce','permissions'], 'safe'],
            [['discount'], 'number'],
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
        $query = MemberSorts::find();

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
            'price_1' => $this->price_1,
            'price_2' => $this->price_2,
            'price_3' => $this->price_3,
            'discount' => $this->discount,
        ]);

        $query->andFilterWhere(['like', 'member_name', $this->member_name])
            ->andFilterWhere(['like', 'member_introduce', $this->member_introduce])
            ->andFilterWhere(['like', 'permissions', $this->permissions]);

        return $dataProvider;
    }
}
