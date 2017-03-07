<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/9
 * Time: 16:35
 */

namespace api\modules\v8\models;

use Yii;
use app\components\db\ActiveRecord;

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

            'id','user_id','number','giveaway','refund','subject','order_number','type','status',
            'extra'=>function($model){
                $model['extra']=json_decode($model['extra'],true);
                if($model['extra']){
                    $data = array();
                    $data['mark'] = is_null(json_decode($model['extra']['mark']))?$model['extra']['mark']:json_decode($model['extra']['mark']);
                    $data['require'] = is_null(json_decode($model['extra']['require']))?$model['extra']['require']:json_decode($model['extra']['require']);
                    $data['avatar'] = $model['extra']['avatar'];
                    $data['worth'] = $model['extra']['worth'];
                    $data['address'] = $model['extra']['address'];
                    $data['introduction'] = $model['extra']['introduction'];
                    return $data;
                }
                return $model['extra'];
            },
            'created_at','updated_at',
        ];
    }

}