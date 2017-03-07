<?php
namespace api\modules\v5\models;
use app\components\db\ActiveRecord;
use Yii;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/3
 * Time: 10:22
 */

/**
 * This is the model class for table "pre_recharge_record".
 *
 * @property integer $user_id
 * @property integer $order_number
 * @property integer $alipay_order
 * @property integer $giveaway
 * @property integer $number
 * @property integer $week_time
 * @property integer $subject
 * @property integer $mouth_time
 * @property string $type
 * @property string $extra
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $platform
 * @property integer $channel
 */
class Order extends ActiveRecord
{

    public $sorts_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%recharge_record}}";
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            //[['user_id', 'status','type','order_number',], 'required'],
            [['type','channel'], 'string'],
            [['number'], 'double'],
            [['subject','order_number','user_id','sorts_id'], 'number'],
            ['order_number', 'orderUnique'],
        ];
    }

    public function orderUnique(){

        $query = (new Query())->select('order_number')->from('pre_recharge_record')->where(['order_number'=>$this->order_number])->one();
        if(!empty($query)){
            $this->addError('order_number', '订单号已存在.');
        }

    }
    public function attributeLabels()
    {
        return [
            'id'    =>  'ID',
            'user_id' => 'user_ID',
            'order_number' => 'order_number',
            'number' => 'number',
            'subject' => 'subject',
            'extra' => 'extra',
            'created_at'    =>   'created_at',
            'updated_at'    =>   'updated_at',
            'week_time'    =>   'week_time',
            'mouth_time'    =>   'mouth_time',
            'alipay_order'    =>   'alipay_order',
            'type'    =>   'type',
            'status'    =>   'status',
            'giveaway'    =>   'giveaway',
            'platform'    =>   'platform',
            'channel'    =>   'channel',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'user_id',
            'order_number',
            'number',
            'subject',
            'type',
            'extra',
            'created_at',
            'updated_at',
            'created_at',
            'week_time',
            'mouth_time',
            'alipay_order',
            'giveaway',
            'platform',
            'channel',
        ];
    }
}