<?php

namespace backend\models;

use backend\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupid', 'role', 'status', 'created_at', 'updated_at','sex'], 'integer'],
            [['id','username','identify', 'password_hash', 'number','password_reset_token', 'auth_key', 'email', 'avatar','cellphone','sex','cid','nickname','cid'], 'safe'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!empty($this->number)){
            $user_iid = User::getIds($this->number);
        }else{
            $user_iid = "";
        }

        $query->andFilterWhere([

            'pre_user.id' => $this->id,
            'id' => $user_iid,
            'role' => $this->role,
            'status' => $this->status,
            'groupid' => $this->groupid,
            'identify' => $this->identify,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sex' => $this->sex,
            'cid' => $this->cid,
            'nickname' => $this->nickname,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'identify', $this->identify])
            ->andFilterWhere(['like', 'cellphone', $this->cellphone])
            ->andFilterWhere(['like', 'avatar', $this->avatar]);

        return $dataProvider;
    }
}
