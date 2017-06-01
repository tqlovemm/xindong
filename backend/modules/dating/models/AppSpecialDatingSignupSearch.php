<?php

namespace backend\modules\dating\models;
use api\modules\v9\models\AppSpecialDatingSignUp;
use yii\base\Model;
use yii\data\Pagination;

/**
 * AppSpecialDaingSearch represents the model behind the search form about `backend\modules\dating\models\AppSpecialDating`.
 */
class AppSpecialDatingSignupSearch extends AppSpecialDatingSignUp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zid','status','user_id','sid'], 'integer'],
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
     * @param $params
     * @return array
     */
    public function search($params)
    {

        $data = AppSpecialDatingSignUp::find();


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '24']);
            $model = $data->offset($pages->offset)->limit($pages->limit)->all();
           return array('model'=>$model,'pages'=>$pages);
        }

        $data->andFilterWhere([
            'zid' => $this->zid,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'sid' => $this->sid,
        ]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '24']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return array('model'=>$model,'pages'=>$pages);
    }
}
