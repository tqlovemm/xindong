<?php

namespace frontend\modules\forum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\forum\models\AnecdoteThreadThumbs;

/**
 * AnecdoteThreadThumbsSearch represents the model behind the search form about `frontend\modules\forum\models\AnecdoteThreadThumbs`.
 */
class AnecdoteThreadThumbsSearch extends AnecdoteThreadThumbs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thumbs_id', 'tid', 'type', 'where'], 'integer'],
            [['user_id'], 'safe'],
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
        $query = AnecdoteThreadThumbs::find();

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
            'thumbs_id' => $this->thumbs_id,
            'tid' => $this->tid,
            'type' => $this->type,
            'where' => $this->where,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id]);

        return $dataProvider;
    }
}
