<?php

namespace backend\modules\app\models;

use Yii;

/**
 * This is the model class for table "pre_app_order_list".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $order_number
 * @property string $alipay_order
 * @property string $total_fee
 * @property integer $giveaway
 * @property string $subject
 * @property string $extra
 * @property string $channel
 * @property string $description
 * @property integer $type
 * @property integer $status
 * @property integer $month_time
 * @property integer $week_time
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class AppOrderList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_order_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'order_number', 'alipay_order', 'total_fee', 'giveaway', 'subject', 'channel', 'description', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'giveaway', 'type', 'status', 'month_time', 'week_time', 'created_at', 'updated_at'], 'integer'],
            [['total_fee'], 'number'],
            [['extra'], 'string'],
            [['order_number', 'alipay_order', 'description'], 'string', 'max' => 255],
            [['subject'], 'string', 'max' => 50],
            [['channel'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'order_number' => '商户订单号',
            'alipay_order' => '支付订单号',
            'total_fee' => '支付金额',
            'giveaway' => '赠送金额',
            'subject' => '购买商品',
            'extra' => 'Extra',
            'channel' => '支付方式（支付宝或微信）',
            'description' => '商品描述',
            'type' => '付费类型',
            'status' => '是否可见',
            'month_time' => 'Month Time',
            'week_time' => 'Week Time',
            'created_at' => '日期',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
}
