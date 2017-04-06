<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pre_activity_recharge_record".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $money_id
 * @property integer $is_activity
 * @property integer $created_at
 */
class ActivityRechargeRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_activity_recharge_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'money_id', 'is_activity','created_at'], 'integer']
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
            'money_id' => 'Money ID',
            'is_activity' => 'Is Activity',
            'created_at' => 'Created At',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
