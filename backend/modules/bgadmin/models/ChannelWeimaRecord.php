<?php

namespace backend\modules\bgadmin\models;

/**
 * This is the model class for table "pre_scan_weima_record".
 *
 * @property integer $id
 * @property integer $scene_id
 * @property string $openid
 * @property string $created_at
 * @property integer $status
 */
class ChannelWeimaRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_scan_weima_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scene_id'], 'required'],
            [['scene_id', 'status'], 'integer'],
            [['openid','created_at'], 'string']
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
