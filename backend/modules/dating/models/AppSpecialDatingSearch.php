<?php

namespace backend\modules\dating\models;
use yii\base\Model;
use yii\data\Pagination;

/**
 * AppSpecialDaingSearch represents the model behind the search form about `backend\modules\dating\models\AppSpecialDating`.
 */
class AppSpecialDatingSearch extends AppSpecialDating
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zid','status'], 'integer'],
            [['address'], 'safe'],
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

        $data = AppSpecialDating::find()->andWhere(['status' => 10]);


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
        ]);

        $data->andFilterWhere(['like', 'address', $this->address]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '24']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return array('model'=>$model,'pages'=>$pages);
    }
}
