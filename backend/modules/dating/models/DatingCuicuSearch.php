<?php

namespace backend\modules\dating\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\member\models\DatingCuicu;

/**
 * DatingCuicuSearch represents the model behind the search form about `frontend\modules\member\models\DatingCuicu`.
 */
class DatingCuicuSearch extends DatingCuicu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ccid', 'user_id', 'created_at', 'type'], 'integer'],
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
        $query = DatingCuicu::find()->with('record')->where(['type'=>[0,2]])->orderBy('status asc');

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
            'ccid' => $this->ccid,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'type' => $this->type,
        ]);

        return $dataProvider;
    }
}
