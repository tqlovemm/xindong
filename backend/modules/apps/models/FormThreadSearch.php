<?php

namespace backend\modules\apps\models;

use backend\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v11\models\FormThread;

/**
 * FormThreadSearch represents the model behind the search form about `api\modules\v11\models\FormThread`.
 */
class FormThreadSearch extends FormThread
{
    public $username;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wid',  'sex', 'user_id','updated_at', 'is_top', 'type', 'read_count', 'thumbs_count', 'comments_count', 'admin_count', 'status'], 'integer'],
            [['content', 'tag', 'lat_long', 'created_at', 'address','username'], 'safe'],
            [['total_score'], 'number'],
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

    public function search($params)
    {
        $query = FormThread::find();

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
            $user_iid = empty(User::findOne(['username'=>trim($this->username)]))?'':User::findOne(['username'=>trim($this->username)])->id;
        }else{
            $user_iid = "";
        }
        $query->andFilterWhere([
            'wid' => $this->wid,
            'pre_app_form_thread.user_id' => $this->user_id,
            'user_id' => $user_iid,
            'sex' => $this->sex,
            'updated_at' => $this->updated_at,
            'created_at' => empty($this->created_at)?'':strtotime($this->created_at),
            'is_top' => $this->is_top,
            'type' => $this->type,
            'read_count' => $this->read_count,
            'thumbs_count' => $this->thumbs_count,
            'comments_count' => $this->comments_count,
            'admin_count' => $this->admin_count,
            'total_score' => $this->total_score,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'lat_long', $this->lat_long])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
