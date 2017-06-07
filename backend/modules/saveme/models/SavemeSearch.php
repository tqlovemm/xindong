<?php

namespace backend\modules\saveme\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
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

        $this->load($params);

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
            ->andFilterWhere(['like', 'content', $this->content])
            ->orderBy('created_at desc');

        $pagination = new Pagination([
            'defaultPageSize' => 6,
            'totalCount' => $query->count(),
        ]);
        $dataProvider = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        $arr['page'] = $pagination;
        $arr['data'] = $dataProvider;
        return $arr;
    }
}
