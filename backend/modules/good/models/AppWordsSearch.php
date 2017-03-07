<?php

namespace backend\modules\good\models;

use backend\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\good\models\AppWords;
use yii\db\Exception;
use yii\web\ForbiddenHttpException;

/**
 * AppWordsSearch represents the model behind the search form about `backend\modules\good\models\AppWords`.
 */
class AppWordsSearch extends AppWords
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at', 'updated_at', 'flag', 'status'], 'integer'],
            [['content', 'address', 'img','username'], 'safe'],
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
        $query = AppWords::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(!empty($this->username)){
            $user_iid = User::findOne(['username'=>$this->username])->id;
        }else{
            $user_iid = "";
        }



        $query->andFilterWhere([
            'id' => $this->id,
            'pre_app_words.user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'flag' => $this->flag,
            'status' => $this->status,
            'user_id' => $user_iid,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'img', $this->img]);

        return $dataProvider;
    }
}
