<?php

namespace frontend\modules\member\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "pre_alipay_coin_recharge_record".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $user_number
 * @property string $total_fee
 * @property integer $giveaway
 * @property string $out_trade_no
 * @property string $subject
 * @property string $notify_time
 * @property string $extra
 * @property string $description
 * @property integer $day_time
 * @property integer $week_time
 * @property integer $mouth_time
 * @property integer $type
 *
 * @property User $user
 */
class AlipayCoinRechargeRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_alipay_coin_recharge_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total_fee', 'out_trade_no', 'subject', 'notify_time'], 'required'],
            [['user_id', 'giveaway', 'day_time', 'week_time', 'mouth_time', 'type', 'status', 'platform'], 'integer'],
            [['total_fee'], 'number'],
            [['extra'], 'string'],
            [['out_trade_no', 'notify_time', 'description'], 'string', 'max' => 64],
            [['subject', 'user_number'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '会员ID',
            'user_number' => '会员编号',
            'total_fee' => '总计消费',
            'giveaway' => '赠送节操币',
            'out_trade_no' => '交易订单号',
            'subject' => '商品名称',
            'notify_time' => '交易时间',
            'extra' => '支付详情',
            'description' => '描述',
            'day_time' => '日统计',
            'week_time' => '周统计',
            'mouth_time' => '月统计',
            'type' => '类型(1充币,2升级)',
            'status' => '是否可见',
            'platform' => '平台(1网站,2app)',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->day_time = strtotime('today');
                $this->week_time = strtotime('last Monday');
                $this->mouth_time = mktime(0,0,0,date('m'),1,date('Y'));;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
