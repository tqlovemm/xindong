<?php

namespace backend\modules\vip\models;

use backend\models\User;
use Yii;

/**
 * This is the model class for table "{{%user_vip_expire_date}}".
 *
 * @property integer $vid
 * @property integer $user_id
 * @property string $number
 * @property integer $vip
 * @property integer $type
 * @property string $expire
 * @property integer $created_at
 * @property string $extra
 * @property string $admin
 */
class UserVipExpireDate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_vip_expire_date}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['number', 'unique', 'targetClass' => 'backend\modules\vip\models\UserVipExpireDate','message'=>"该会员编号已经存在"],
            [['user_id', 'vip', 'created_at', 'type'], 'integer'],
            [['number', 'vip'], 'required'],
            [['number'], 'string', 'max' => 16],
            [['admin', 'expire'], 'string', 'max' => 64],
            [['extra'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vid' => 'Vid',
            'user_id' => '用户ID',
            'number' => '会员编号',
            'vip' => '会员等级',
            'expire' => '过期时间',
            'type' => '会员类型',
            'created_at' => '创建时间',
            'extra' => '备注',
            'admin' => '操作管理员',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {

                $this->created_at = time();
                if(!Yii::$app->user->isGuest){
                    $this->admin = Yii::$app->user->identity->username;
                }

                if(!empty($this->number)&&($user = User::getId($this->number))!=null){
                    $this->user_id = $user;
                }

                if(!empty($this->user_id)&&($number = User::getNumber($this->user_id))!=null){
                    $this->number = $number;
                }
            }

            return true;

        } else {
            return false;
        }
    }
}
