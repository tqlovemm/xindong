<?php

namespace api\modules\v8\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/7
 * Time: 17:11
 */

/**
 * This is the model class for table "pre_app_order_list".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $order_number
 * @property integer $alipay_order
 * @property integer $giveaway
 * @property integer $total_fee
 * @property integer $week_time
 * @property integer $subject
 * @property integer $month_time
 * @property string $type
 * @property string $description
 * @property string $extra
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $platform
 * @property integer $channel
 */
class Order extends ActiveRecord
{

    public $sort_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%app_order_list}}";
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['user_id', 'order_number','subject','channel','total_fee','description'], 'required'],
            [['extra','order_number','alipay_order','description'], 'string'],
            [['channel',], 'string','max'=>32],
            [['subject',], 'string','max'=>50],
            [['total_fee'], 'double'],
            [['type','status','month_time','week_time','created_at','updated_at','sort_id'], 'integer'],
            ['order_number','orderUnique'],
        ];
    }

    public function orderUnique(){

        /*$query = (new Query())->select('order_number')->from('pre_app_order_list')->where(['order_number'=>$this->order_number])->one();*/
        $query = $this->findOne(['order_number'=>$this->order_number]);
        if(!empty($query)){
            $this->addError('order_number', '订单号已存在.');
        }

    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = strtotime('today');
                $this->updated_at = time();
                $this->week_time = strtotime('next sunday');
                $this->month_time = mktime(23,59,59,date('m'),date('t'),date('Y'))+1;
            }
            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  'ID',
            'user_id' => 'user_ID',
            'order_number' => 'order_number',
            'total_fee' => 'total_fee',
            'subject' => 'subject',
            'extra' => 'extra',
            'created_at'    =>   'created_at',
            'updated_at'    =>   'updated_at',
            'week_time'    =>   'week_time',
            'month_time'    =>   'month_time',
            'alipay_order'    =>   'alipay_order',
            'type'    =>   'type',
            'status'    =>   'status',
            'sort_id'    =>   'sort_id',
            'giveaway'    =>   'giveaway',
            'channel'    =>   'channel',
            'description'    =>   'description',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'user_id',
            'order_number',
            'alipay_order',
            'total_fee',
            'giveaway',
            'subject',
            'channel',
            'description',
            /*'extra',*/
            'type',
            /*'sort_id',*/
            'status',
            /*'week_time',
            'month_time',
            'day_time',*/
            'created_at',
            'updated_at',
        ];
    }
}