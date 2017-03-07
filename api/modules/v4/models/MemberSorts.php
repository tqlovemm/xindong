<?php

namespace api\modules\v4\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "pre_member_sorts".
 *
 * @property integer $id
 * @property integer $groupid
 * @property string $member_name
 * @property string $member_introduce
 * @property string $permissions
 * @property integer $price_1
 * @property integer $price_2
 * @property integer $price_3
 * @property double $discount
 */
class MemberSorts extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%member_sorts}}';
    }

    public function rules()
    {
        return [

            [['id','groupid','price_1','price_2','price_3'], 'integer'],
            [['discount'], 'number'],
            [['member_name','member_introduce','permissions'], 'string'],
        ];
    }
    public function attributeLabels()
    {
        return [

            'id' => 'ID',
            'groupid' => '用户等级',
            'price_1' => '价格一',
            'price_2' => '价格二',
            'price_3' => '价格三',
            'discount' => '折扣',
            'member_name' => '会员名称',
            'member_introduce' => '会员简介',
            'permissions' => '会员权限',
        ];
    }

    public function fields()
    {

        return [

            'member_id'=>'id',
            'groupid',
            'price_1'=>function($model){

                return $model['price_1'].'(北上广深苏浙)';

            },
            'price_2'=>function($model){

                return $model['price_2'].'(新蒙青甘藏宁琼)';

            },
            'price_3'=>function($model){

                return $model['price_3'].'(包括海外在内的其他地区)';

            },

            'discount','member_name','member_introduce',

            'permissions'=>function($model){

                $list = explode('@',$model['permissions']);
                $data['key'] = array();
                $data['value'] = array();
                foreach ($list as $key=>$item){

                    array_push($data['key'],explode('：',$item)[0]);
                    array_push($data['value'],explode('：',$item)[1]);
                }

                return $data;

            }

        ];

    }


}


?>
