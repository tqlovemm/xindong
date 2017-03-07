<?php

namespace backend\modules\setting\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "pre_credit_reward_record".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $user_number
 * @property integer $type
 * @property integer $value
 * @property string $reason
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class CreditRewardRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_credit_reward_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_number', 'type', 'value', 'reason', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'type', 'value', 'created_at', 'updated_at'], 'integer'],
            [['user_number'], 'string', 'max' => 50],
            [['reason'], 'string', 'max' => 512]
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
            'user_number' => 'User Number',
            'type' => 'Type',
            'value' => 'Value',
            'reason' => 'Reason',
            'created_at' => 'Created At',
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
}
