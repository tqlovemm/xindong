<?php

namespace backend\modules\vip\models;

use yii\base\Model;
use yii\data\Pagination;
use yii\data\Sort;

/**
 * GirlMemberSearch represents the model behind the search form about `backend\modules\home\models\GirlMember`.
 */
class UserVipExpireDateSearch extends UserVipExpireDate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'vip','expire','created_at','type'], 'integer'],
            [['number', 'extra','admin'], 'safe'],
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
        $sort = new Sort([
            'attributes' => [
                'expire' => [
                    'asc' => ['expire' => SORT_ASC],
                    'desc' => ['expire' => SORT_DESC],
                    'label' => '过期时间排序',
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'label' => '创建时间排序',
                ],
                'type' => [
                    'asc' => ['type' => SORT_ASC],
                    'desc' => ['type' => SORT_DESC],
                    'label' => '会员类型排序',
                ],
            ],
        ]);

        $data = UserVipExpireDate::find()->orderBy($sort->orders);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '18']);
            $model = $data->offset($pages->offset)->limit($pages->limit)->all();
           return array('model'=>$model,'pages'=>$pages);
        }

        $data->andFilterWhere([
            'user_id' => $this->user_id,
            'vip' => $this->vip,
            'type' => $this->type,
        ]);

        $data->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'admin', $this->admin])
            ->andFilterWhere(['like', 'extra', $this->extra]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '18']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return array('model'=>$model,'pages'=>$pages,'sort'=>$sort);
    }
}
