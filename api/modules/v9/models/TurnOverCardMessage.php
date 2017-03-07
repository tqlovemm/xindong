<?php

namespace api\modules\v9\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "pre_turn_over_card_message".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $from
 * @property string $message
 * @property integer $palace_id
 * @property integer $flag
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property User $from0
 */
class TurnOverCardMessage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_turn_over_card_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'from', 'message',], 'required'],
            [['user_id', 'from', 'palace_id','flag', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '消息接受者id',
            'from' => '消息推送者id',
            'message' => '推送的消息',
            'palace_id' => 'palace_id',
            'flag' => '推送状态',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom0()
    {
        return $this->hasOne(User::className(), ['id' => 'from']);
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = strtotime('today');
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

    public function fields()
    {
        return [
            'id','user_id','from','palace_id','message','flag','created_at','updated_at',
        ];
    }
}
