<?php

namespace api\modules\v4\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "pre_recharge_record".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $number
 * @property integer $giveaway
 * @property integer $refund
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $subject
 * @property integer $status
 * @property string $order_number
 * @property string $extra
 */
class RechargeRecord extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%recharge_record}}';
    }

    public function rules()
    {
        return [

            [['user_id','number','giveaway','refund','created_at','updated_at','subject','status'], 'integer'],
            [['order_number','extra'], 'string'],
        ];
    }
    public function attributeLabels()
    {
        return [

            'user_id' => '会员ID',
            'number' => '节操币数量',
            'giveaway' => '赠送节操币',
            'refund' => '返回节操币',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'subject' => '类型',
            'status' => '状态',
            'order_number' => '订单号',
            'extra' => '其他',
        ];
    }

    public function fields()
    {

        return [

            'id',
            'user_id'=>function($model){

                return (string)$model['user_id'];
            },
            'number'=>function($model){

                return (string)$model['number'];
            },
            'giveaway'=>function($model){

                return (string)$model['giveaway'];
            },
            'refund'=>function($model){

                return (string)$model['refund'];
            },
            'created_at'=>function($model){

                return (string)$model['created_at'];
            },
            'updated_at'=>function($model){

                return (string)$model['updated_at'];
            },
            'subject'=>function($model){

                return (string)$model['subject'];
            },
            'status'=>function($model){

                return (string)$model['status'];
            },
            'type'=>function($model){

                return (string)$model['type'];
            },
            'order_number',

            'extra'=>function($model){

                if(empty($model['extra'])){

                    return $model['extra']=array(
                          "mark"=> "",
                          "require"=> "",
                          "introduction"=> "",
                          "worth"=> "",
                          "avatar"=> "http://13loveme.com/images/member/wallet.png",
                          "number"=> "",
                          "address"=> ""
                    );

                }
                $datingUserInfo = json_decode($model['extra'],true);
                if(strpos($datingUserInfo['avatar'],'http://13loveme.com:82/')!==false){
                    $avatar = str_replace('http://13loveme.com:82/',Yii::$app->params['shisangirl'],$datingUserInfo['avatar']);
                }elseif(strpos($datingUserInfo['avatar'],'http://13loveme.com/')!==false){
                    $avatar = str_replace('http://13loveme.com/',Yii::$app->params['shisangirl'],$datingUserInfo['avatar']);
                }else{
                    $avatar=$datingUserInfo['avatar'];
                }
                $datingUserInfo['avatar']= $avatar;
                /*$avatar = str_replace(Yii::$app->params['shisangirl'],'',$datingUserInfo['avatar']);
                unset($datingUserInfo['avatar']);*/
                return $datingUserInfo;

            }

        ];

    }


}


?>
