<?php

namespace common\models;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%coin_consumption_details}}".
 *
 * @property integer $cid
 * @property integer $user_id
 * @property integer $coin
 * @property string $transaction
 * @property string $extra
 * @property integer $created_at
 * @property string $type
 * @property integer $balance
 */
class CoinConsumptionDetails extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coin_consumption_details}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coin', 'created_at', 'balance','user_id'], 'integer'],
            [['transaction'], 'string', 'max' => 32],
            [['extra'], 'string', 'max' => 256],
            [['type'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'user_id' => 'User ID',
            'coin' => 'Coin',
            'transaction' => 'Transaction',
            'extra' => 'Extra',
            'created_at' => 'Created At',
            'type' => 'Type',
            'balance' => 'Balance',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
            }
            return true;
        }
        return false;
    }
}
