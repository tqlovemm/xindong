<?php

namespace backend\modules\saveme\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\saveme\models\SavemeInfo;

/**
 * SavemeInfoSearch represents the model behind the search form about `backend\modules\saveme\models\SavemeInfo`.
 */
class SavemeInfoSearch extends SavemeInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'saveme_id', 'apply_uid', 'created_at', 'updated_at', 'type', 'status'], 'integer'],
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
        $query = SavemeInfo::find();

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
            'saveme_id' => $this->saveme_id,
            'apply_uid' => $this->apply_uid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
