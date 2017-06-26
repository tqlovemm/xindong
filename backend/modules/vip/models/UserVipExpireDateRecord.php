<?php

namespace backend\modules\vip\models;

use Yii;

/**
 * This is the model class for table "{{%user_vip_expire_date_record}}".
 *
 * @property integer $rid
 * @property integer $user_id
 * @property string $number
 * @property integer $vip
 * @property string $expire
 * @property integer $type
 * @property integer $created_at
 * @property string $admin
 * @property string $extra
 */
class UserVipExpireDateRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_vip_expire_date_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'vip', 'type', 'created_at'], 'integer'],
            [['number', 'vip'], 'required'],
            [['number'], 'string', 'max' => 16],
            [['expire'], 'string', 'max' => 32],
            [['admin'], 'string', 'max' => 64],
            [['extra'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => 'Rid',
            'user_id' => 'User ID',
            'number' => 'Number',
            'vip' => 'Vip',
            'expire' => 'Expire',
            'type' => 'Type',
            'created_at' => 'Created At',
            'admin' => 'Admin',
            'extra' => 'Extra',
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
            }
            return true;
        } else {
            return false;
        }
    }
}
