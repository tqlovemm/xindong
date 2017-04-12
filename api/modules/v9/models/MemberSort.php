<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/27
 * Time: 13:27
 */

namespace api\modules\v9\models;

use api\modules\v4\models\User;
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

    public $realPrice;
    public $realGiveaway;
    public $detail_link;
    public static function tableName()
    {
        return '{{%member_sorts}}';
    }

    public function rules()
    {
        return [
            [['id','groupid','giveaway','price_1','is_recommend','is_status'],'integer'],
            [['member_name','member_introduce','permissions','detail_link'],'string'],
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
            'realPrice'   =>  '升级补差价',
            'price_1'   =>  '价格',
            'giveaway'  =>  '赠送心动币',
            'realGiveaway'  =>  '补差赠送的心动币',
            'is_recommend'  =>  '求推荐',
            'discount'  =>  '折扣',
            'detail_link'  =>  '详情链接',
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
            'realGiveaway'=>function($model){
                $user_id = $_GET['uid'];
                $userLevel = User::find()->select("groupid")->where(['id'=>$user_id])->one();
                $price = $this->find()->select("giveaway")->where(['groupid'=>$userLevel['groupid'],'flag'=>[1,3]])->one();
                if( $userLevel['groupid'] == 1){
                    if($this->groupid == 2){
                        return 0;
                    }elseif($this->groupid == 3){
                        return 0;
                    }elseif($this->groupid == 4){
                        return 0;
                    }else{
                        return 0;
                    }
                }elseif($userLevel['groupid'] == 2  ){
                    if($this->groupid == 2){
                        return 0;
                    }elseif($this->groupid == 3){
                        return $model['giveaway'] - $price['giveaway'];
                    }elseif($this->groupid == 4){
                        return $model['giveaway'] - $price['giveaway'];
                    }else{
                        return 0;
                    }
                }elseif( $userLevel['groupid'] == 3 ){

                    if( $this->groupid == 3 ){
                        return 0;
                    }elseif( $this->groupid == 4 ){
                        return  $model['giveaway'] - $price['giveaway'];
                    }else{
                        return 0;
                    }
                }else{
                    return 0;
                }
            },
            'realPrice'=>function($model){

                $user_id = $_GET['uid'];
                $userLevel = User::find()->select("groupid")->where(['id'=>$user_id])->one();
                $price = $this->find()->select("price_1")->where(['groupid'=>$userLevel['groupid'],'flag'=>[1,3]])->one();
                if( $userLevel['groupid'] == 1 ){
                    if($this->groupid == 2){
                        return 0;
                    }elseif($this->groupid == 3){
                        return 0;
                    }elseif($this->groupid == 4){
                        return 0;
                    }

                }elseif( $userLevel['groupid'] == 2 ){

                    if($this->groupid == 2){
                        return 0;
                    }else{
                        return $model['price_1'] - $price['price_1'];
                    }
                }elseif( $userLevel['groupid'] == 3 ){
                    if( $this->groupid == 2 || $this->groupid == 3 ){
                        return 0;
                    }else{
                        return  $model['price_1'] - $price['price_1'];
                    }
                }else{
                    return 0;
                }
            },
            'discount',
            'is_recommend',
            'detail_link'=>function($model){
                if($model->groupid!=2){
                    $msort = MemberSort::findOne(['member_name'=>$this->member_name,'flag'=>0]);
                    return "http://13loveme.com/member/user-show/update-details?id=".$msort->id.'&top=2&uid=';
                }

            },
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