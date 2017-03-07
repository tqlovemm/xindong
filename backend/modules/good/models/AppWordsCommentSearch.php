<?php

namespace backend\modules\good\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\good\models\AppWordsComment;

/**
 * AppWordsCommentSearch represents the model behind the search form about `backend\modules\good\models\AppWordsComment`.
 */
class AppWordsCommentSearch extends AppWordsComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'words_id', 'first_id', 'second_id', 'flag', 'created_at', 'updated_at'], 'integer'],
            [['img', 'comment'], 'safe'],
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
        $query = AppWordsComment::find();

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
            'words_id' => $this->words_id,
            'first_id' => $this->first_id,
            'second_id' => $this->second_id,
            'flag' => $this->flag,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
