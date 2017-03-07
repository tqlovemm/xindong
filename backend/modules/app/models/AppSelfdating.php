<?php

namespace backend\modules\app\models;

use Yii;

/**
 * This is the model class for table "pre_app_selfdating".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sex
 * @property integer $level
 * @property integer $pay
 * @property string $nickname
 * @property string $address
 * @property string $avatar
 * @property integer $status
 * @property integer $expire
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class AppSelfdating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_selfdating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sex', 'level', 'pay', 'status', 'expire', 'created_at', 'updated_at'], 'integer'],
            [['nickname', 'address', 'avatar'], 'string', 'max' => 250]
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
            'sex' => 'Sex',
            'level' => 'Level',
            'pay' => 'Pay',
            'nickname' => 'Nickname',
            'address' => 'Address',
            'avatar' => 'Avatar',
            'status' => 'Status',
            'expire' => 'Expire',
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
