<?php

namespace backend\modules\authentication\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\authentication\models\GirlFlopPrompt;

/**
 * GirlFlopPromptSearch represents the model behind the search form about `backend\modules\authentication\models\GirlFlopPrompt`.
 */
class GirlFlopPromptSearch extends GirlFlopPrompt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['content'], 'safe'],
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
        $query = GirlFlopPrompt::find();

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
