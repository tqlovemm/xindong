<?php

namespace backend\modules\dating\models;

use Yii;

/**
 * This is the model class for table "pre_user_weichat_push".
 *
 * @property integer $id
 * @property integer $status
 * @property string $openid
 * @property string $remark
 * @property string $number
 * @property integer $created_at
 */
class UserWeichatPush extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user_weichat_push';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'number'], 'required'],
            [['created_at','status'], 'integer'],
            [['openid','remark'], 'string', 'max' => 64],
            [['number'], 'string', 'max' => 16]
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'remark' => 'Remark',
            'number' => 'Number',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
