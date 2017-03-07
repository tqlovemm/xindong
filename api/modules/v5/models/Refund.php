<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/11
 * Time: 16:02
 */

namespace api\modules\v5\models;
use Yii;
use yii\db\Query;
use app\components\db\ActiveRecord;


/**
 * This is the model class for table "pre_refund".
 *
 * @property integer $rid
 * @property integer $user_id
 * @property string $refund_order
 * @property integer $amount
 * @property string $user_order_no
 * @property string $charge_order_no
 */
class Refund extends ActiveRecord
{
    public static function className()
    {
        return "{{%refund}}";
    }

    public function rules()
    {
        return [
            [['rid','user_id','amount'],'integer'],
            [['refund_order','user_order_no','charge_order_no'],'string'],
        ];
    }

    public function attributeLabels(){

        return [
            'rid'   =>  'refund_id',
            'user_id'   =>  'user_id',
            'amount'    =>  'amount',
            'refund_order'  =>  'refund_order',
            'user_order_no' =>  'user_order_no',
            'charge_order_no'   =>  'charge_order_no',
        ];
    }

    public function fields(){

        return [
            'rid','user_id','amount','refund_order','user_order_no','charge_order_no',
        ];
    }

}