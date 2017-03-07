<?php

namespace frontend\modules\member\models;

use Yii;

/**
 * This is the model class for table "pre_user_vip_temp_adjust".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $vip
 * @property integer $created_at
 * @property integer $status
 */
class UserVipTempAdjust extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user_vip_temp_adjust';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'vip'], 'required'],
            [['user_id', 'vip', 'created_at', 'status'], 'integer']
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->status = 10;
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'vip' => 'Vip',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
