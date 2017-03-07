<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pre_weipay_record".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property integer $giveaway
 * @property string $out_trade_no
 * @property integer $total_fee
 * @property string $transaction_id
 * @property string $extra
 * @property string $detail
 * @property integer $created_at
 * @property integer $updated_at
 */
class WeipayRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_weipay_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'out_trade_no', 'total_fee', 'transaction_id', 'extra', 'detail', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'total_fee','type','giveaway', 'created_at', 'updated_at'], 'integer'],
            [['extra', 'detail'], 'string'],
            [['out_trade_no'], 'string', 'max' => 50],
            [['transaction_id'], 'string', 'max' => 32]
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
            'type' => 'Type',
            'giveaway' => 'Giveaway',
            'out_trade_no' => 'Out Trade No',
            'total_fee' => 'Total Fee',
            'transaction_id' => 'Transaction ID',
            'extra' => 'Extra',
            'detail' => 'Detail',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
