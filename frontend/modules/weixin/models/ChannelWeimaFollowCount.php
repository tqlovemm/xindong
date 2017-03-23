<?php

namespace frontend\modules\weixin\models;

use backend\modules\bgadmin\models\ChannelWeima;
use Yii;

/**
 * This is the model class for table "pre_channel_weima_follow_count".
 *
 * @property integer $id
 * @property integer $sence_id
 * @property integer $new_subscribe
 * @property integer $new_unsubscribe
 * @property integer $old_subscribe
 * @property integer $old_unsubscribe
 * @property integer $scan
 * @property integer $created_at
 */
class ChannelWeimaFollowCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_channel_weima_follow_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sence_id'], 'required'],
            [['sence_id', 'new_subscribe', 'new_unsubscribe', 'old_subscribe', 'old_unsubscribe', 'scan', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sence_id' => 'Sence ID',
            'new_subscribe' => 'New Subscribe',
            'new_unsubscribe' => 'New Unsubscribe',
            'old_subscribe' => 'Old Subscribe',
            'old_unsubscribe' => 'Old Unsubscribe',
            'scan' => 'Scan',
            'created_at' => 'Created At',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = strtotime('today');
            }
            return true;
        }
        return false;
    }

    public function getWm()
    {
        return $this->hasOne(ChannelWeima::className(), ['sence_id'=>'sence_id' ]);
    }
}
