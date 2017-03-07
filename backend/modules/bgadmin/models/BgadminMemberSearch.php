<?php

namespace backend\modules\bgadmin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\bgadmin\models\BgadminMember;

/**
 * BgadminMemberSearch represents the model behind the search form about `backend\modules\bgadmin\models\BgadminMember`.
 */
class BgadminMemberSearch extends BgadminMember
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'sex', 'vip', 'status', 'created_by'], 'integer'],
            [['number', 'weicaht', 'weibo', 'cellphone', 'address_a', 'address_b', 'time', 'updated_at', 'created_at','coin'], 'safe'],
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
        $query = BgadminMember::find()->where(['sex'=>0])->orderBy('created_at desc');

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
            'member_id' => $this->member_id,
            'sex' => $this->sex,
            'vip' => $this->vip,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'coin' => $this->coin,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'weicaht', $this->weicaht])
            ->andFilterWhere(['like', 'weibo', $this->weibo])
            ->andFilterWhere(['like', 'cellphone', $this->cellphone])
            ->andFilterWhere(['like', 'address_a', $this->address_a])
            ->andFilterWhere(['like', 'address_b', $this->address_b])
            ->andFilterWhere(['like', 'time', $this->time])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search_girl($params)
    {
        $query = BgadminMember::find()->where(['sex'=>1])->orderBy('created_at desc');

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
            'member_id' => $this->member_id,
            'sex' => $this->sex,
            'vip' => $this->vip,
            'status' => $this->status,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'weicaht', $this->weicaht])
            ->andFilterWhere(['like', 'weibo', $this->weibo])
            ->andFilterWhere(['like', 'cellphone', $this->cellphone])
            ->andFilterWhere(['like', 'address_a', $this->address_a])
            ->andFilterWhere(['like', 'address_b', $this->address_b])
            ->andFilterWhere(['like', 'time', $this->time])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
    public function search_firefighters($params)
    {
        $query = BgadminMember::find()->where(['sex'=>9])->orderBy('created_at desc');

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
            'member_id' => $this->member_id,
            'sex' => $this->sex,
            'vip' => $this->vip,
            'status' => $this->status,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'weicaht', $this->weicaht])
            ->andFilterWhere(['like', 'weibo', $this->weibo])
            ->andFilterWhere(['like', 'cellphone', $this->cellphone])
            ->andFilterWhere(['like', 'address_a', $this->address_a])
            ->andFilterWhere(['like', 'address_b', $this->address_b])
            ->andFilterWhere(['like', 'time', $this->time])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
