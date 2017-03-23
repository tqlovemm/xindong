<?php

namespace frontend\modules\weixin\models;

use backend\modules\bgadmin\models\ChannelWeima;
use Yii;

/**
 * This is the model class for table "pre_channel_weima_record".
 *
 * @property integer $id
 * @property integer $scene_id
 * @property string $openid
 * @property integer $created_at
 * @property integer $subscribe_time
 * @property string $nickname
 * @property string $headimgurl
 * @property string $country
 * @property string $province
 * @property string $city
 * @property integer $sex
 * @property integer $status
 * @property integer $type
 */
class ChannelWeimaRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_channel_weima_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scene_id'], 'required'],
            [['scene_id', 'status','subscribe_time','created_at','sex','type'], 'integer'],
            [['openid','nickname','country','province','city','headimgurl'], 'string']
        ];
    }
    /**
     * @inheritdoc
     */

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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scene_id' => 'Scene ID',
            'openid' => 'Open ID',
            'created_at' => 'Created At',
            'status' => 'Status',
            'subscribe_time' => 'Subscribe Time',
            'sex' => 'Sex',
            'nickname' => 'Nickname',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'headimgurl' => 'Headimgurl',
            'type' => 'Type',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(ChannelWeima::className(), [ 'sence_id'=>'scene_id' ]);
    }
}
