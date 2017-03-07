<?php

namespace backend\modules\app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\app\models\TurnOverCardJudge;

/**
 * TurnOverCardJudgeSearch represents the model behind the search form about `backend\modules\app\models\TurnOverCardJudge`.
 */
class TurnOverCardJudgeSearch extends TurnOverCardJudge
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'for_who', 'num', 'flag', 'created_at', 'updated_at'], 'integer'],
            [['mark', 'judge'], 'safe'],
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
        $query = TurnOverCardJudge::find();

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
            'user_id' => $this->user_id,
            'for_who' => $this->for_who,
            'num' => $this->num,
            'flag' => $this->flag,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'mark', $this->mark])
            ->andFilterWhere(['like', 'judge', $this->judge]);

        return $dataProvider;
    }
}
