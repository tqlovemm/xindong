<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/10
 * Time: 10:08
 */

namespace api\modules\v5\models;

use Yii;
use app\components\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "pre_member_sorts".
 *
 * @property integer $id;
 * @property integer $groupid;
 * @property string $member_name;
 * @property string $member_introduce;
 * @property string $permissions;
 * @property integer $giveaway;
 * @property integer $price_1;
 * @property double $discount;
 * @property integer $flag;
 * @property integer $is_recommend;
 * @property integer $is_status;
 *
 */

class MemberSort extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%member_sorts}}';
    }

    public function rules()
    {
        return [
            [['id','groupid','giveaway','price_1','is_recommend','is_status'],'integer'],
            [['member_name','member_introduce','permissions'],'string'],
            [['discount'], 'number'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  'member_id',
            'groupid'   =>  '用户等级',
            'member_name'   =>  '会员名',
            'member_introduce'  =>  '会员介绍',
            'permissions'   =>  '会员权限',
            'price_1'   =>  '价格',
            'giveaway'  =>  '赠送心动币',
            'is_recommend'  =>  '求推荐',
            'discount'  =>  '折扣',
            'flag'  => 'app',
            'is_status'  => 'is_status',
        ];
    }

    public function fields()
    {
        return [
            'member_id' =>  'id',
            'groupid',
            'price_1',
            'member_name',
            'member_introduce',
            'giveaway',
            'discount',
            'is_recommend',
            //'is_status'=>$model['is_status'],
            'flag',
            'permissions'=> function($model){

            $list = explode('@',$model['permissions']);
            $data['key'] = array();
            $data['value'] = array();
            foreach ($list as $key=>$item){

                array_push($data['key'],explode('：',$item)[0]);
                array_push($data['value'],explode('：',$item)[1]);
            }
            return $data;
        }];
    }


}