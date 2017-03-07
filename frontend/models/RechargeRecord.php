<?php

namespace frontend\models;

use Yii;
use common\models\User;
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
 * @property integer $week_time
 * @property integer $mouth_time
 * @property string $order_number
 * @property string $alipay_order
 * @property string $type
 * @property string $buyer_id
 * @property string $buyer_email
 * @property integer $subject
 * @property string $extra
 * @property int $status
 *
 * @property User $user
 */
class RechargeRecord extends \yii\db\ActiveRecord
{
    const STATUS=10;
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
            [['number'], 'required','message'=>'{attribute}不可为空'],
            [['user_id', 'created_at','week_time','mouth_time', 'updated_at','number','subject','giveaway','status','refund'], 'integer','message'=>'{attribute}必须为整数'],
            [['order_number','alipay_order','type','buyer_id','buyer_email'], 'string', 'max' => 125],
            [['extra'], 'string'],
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
            'number' => '金额',
            'giveaway' => '额外赠送',
            'refund' => '返还',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'week_time' => 'Week Time',
            'mouth_time' => 'Mouth Time',
            'order_number' => 'Order Number',
            'alipay_order' => 'Order Number',
            'type' => 'Order Number',
            'buyer_id' => 'Order Number',
            'buyer_email' => 'Order Number',
            'subject'=>'subject',
            'extra'=>'extra',
            'status'=>'status',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {

                $this->created_at = strtotime('today');
                $this->updated_at = time();
                $this->week_time = strtotime('next Sunday');
                $this->mouth_time = mktime(0,0,0,date('m'),date('t')+1,date('Y'));;
                $this->user_id = !empty(Yii::$app->user->id)?Yii::$app->user->id:10000;
                $this->status = self::STATUS;
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
