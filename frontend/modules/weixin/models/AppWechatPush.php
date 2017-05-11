<?php

namespace frontend\modules\weixin\models;

use Yii;

/**
 * This is the model class for table "pre_app_wechat_push".
 *
 * @property integer $wp_id
 * @property integer $recharge_id
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $wechat
 * @property string $extra
 */
class AppWechatPush extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_wechat_push';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recharge_id','user_id'],'required'],
            [['wp_id','user_id', 'recharge_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['wechat','extra'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wp_id' => 'Wp ID',
            'recharge_id' => 'Recharge ID',
            'user_id' => 'User ID',
            'wechat' => 'Wechat',
            'extra' => 'Extra',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
