<?php

namespace backend\modules\bgadmin\models;

use frontend\modules\weixin\models\ChannelWeimaFollowCount;
use Yii;

/**
 * This is the model class for table "pre_channel_weima".
 *
 * @property integer $sence_id
 * @property integer $tag_id
 * @property string $customer_service
 * @property string $account_manager
 * @property string $description
 * @property string $local_path
 * @property string $remote_path
 * @property integer $created_by
 * @property integer $created_at
 */
class ChannelWeima extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_channel_weima';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_service', 'account_manager'], 'required'],
            [['tag_id','created_by','created_at'], 'integer'],
            [['customer_service', 'account_manager'], 'string', 'max' => 64],
            [['description','local_path','remote_path'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sence_id' => 'Sence ID',
            'tag_id' => 'Tag ID',
            'customer_service' => '客服人员',
            'account_manager' => '博主',
            'description' => '描述',
            'local_path' => '本地二维码地址',
            'remote_path' => '远程二维码地址',
            'created_by' => '创建人',
            'created_at' => '创建时间',

        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->created_by = Yii::$app->user->id;
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCount()
    {
        return $this->hasOne(ChannelWeimaFollowCount::className(), ['sence_id' => 'sence_id'])->where(['created_at'=>strtotime('today')]);
    }
    public function getNum()
    {
        return $this->hasMany(ChannelWeimaRecord::className(), ['scene_id' => 'sence_id'])->where(['status'=>1]);
    }
}
