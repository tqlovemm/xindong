<?php

namespace backend\modules\bgadmin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\weixin\models\UserWeichat;

/**
 * UserWeichatSearch represents the model behind the search form about `frontend\modules\weixin\models\UserWeichat`.
 */
class UserWeichatSearch extends UserWeichat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'number', 'nickname', 'headimgurl', 'address'], 'safe'],
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
        $query = UserWeichat::find()->orderBy('created_at desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'headimgurl', $this->headimgurl])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
