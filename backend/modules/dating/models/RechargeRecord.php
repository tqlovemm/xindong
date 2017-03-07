<?php

namespace backend\modules\dating\models;

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
 * @property string $order_number
 * @property string $alipay_order
 * @property integer $subject
 * @property string $type
 * @property string $buyer_email
 * @property string $buyer_id
 * @property string $extra
 * @property integer $status
 * @property integer $reason
 * @property integer $handler
 * @property integer $platform
 * @property integer $to
 *
 * @property User $user
 */
class RechargeRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_recharge_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'number', 'giveaway','refund', 'created_at', 'updated_at', 'subject', 'status', 'platform','to'], 'integer'],
            [['extra','handler'], 'string'],
            [['order_number', 'alipay_order', 'type', 'buyer_email', 'buyer_id'], 'string', 'max' => 125]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'number' => 'Number',
            'giveaway' => 'Giveaway',
            'refund' => 'Refund',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'order_number' => 'Order Number',
            'alipay_order' => 'Alipay Order',
            'subject' => 'Subject',
            'type' => 'Type',
            'buyer_email' => 'Buyer Email',
            'buyer_id' => 'Buyer ID',
            'extra' => 'Extra',
            'status' => 'Status',
            'handler' => 'Handler',
            'reason' => 'Reason',
            'platform' => 'Platform',
            'to' => 'To',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
