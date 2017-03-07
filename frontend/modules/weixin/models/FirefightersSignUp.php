<?php

namespace frontend\modules\weixin\models;

use backend\modules\exciting\models\OtherTextPic;
use common\models\User;
use Yii;

/**
 * This is the model class for table "pre_firefighters_sign_up".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sign_id
 * @property integer $created_at
 * @property integer $status
 * @property string $reason
 * @property string $handler
 * @property string $number
 *
 * @property OtherTextPic $sign
 * @property User $user
 */
class FirefightersSignUp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_firefighters_sign_up';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sign_id'], 'required'],
            [['user_id', 'sign_id', 'created_at', 'status'], 'integer'],
            [['reason'], 'safe'],
            [['handler','number'], 'string', 'max' => 16],
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
            'sign_id' => 'Sign ID',
            'created_at' => 'Created At',
            'status' => 'Status',
            'number' => 'Number',
        ];
    }
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->user_id = Yii::$app->user->id;
            }
            return true;
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSign()
    {
        return $this->hasOne(OtherTextPic::className(), ['pid' => 'sign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
