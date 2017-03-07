<?php

namespace backend\modules\seek\models;

use backend\components\ServicePattersUploader;
use Yii;

/**
 * This is the model class for table "pre_service_patters".
 *
 * @property integer $pid
 * @property string $subject
 * @property string $message
 * @property integer $chrono
 * @property integer $user_id
 * @property string $created_by
 * @property integer $status
 * @property integer $thumbs_up
 */
class ServicePatters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_service_patters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject'], 'required'],
            [['message'], 'string'],
            [['chrono','status','thumbs_up','user_id'], 'integer'],
            [['subject'], 'string', 'max' => 256],
            [['created_by'], 'string', 'max' => 16]
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->chrono = time();
                $this->created_by = Yii::$app->user->identity->username;
                $this->user_id = Yii::$app->user->id;
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
            'pid' => 'ID',
            'subject' => '会员问题',
            'message' => '经典回答',
            'chrono' => '创建时间',
            'created_by' => '创建人',
            'status' => '创建人',
            'thumbs_up' => '创建人',
        ];
    }

    public function getImages()
    {
        return $this->hasMany(ServicePattersImg::className(), ['pid' => 'pid']);
    }
    public function getaddAnswer()
    {
        return $this->hasMany(ServicePattersAddAnswers::className(), ['pid' => 'pid']);
    }

    /**
     * 处理图片的上传
     */
    public function upload()
    {
        $config = [
            'savePath' => Yii::getAlias('@backend').'/web/uploads/pattersImg/', //存储文件夹
            'maxSize' => 4096 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];
        $up = new ServicePattersUploader("file", $config, 'service_patters_'.$this->pid);
        $info = $up->getFileInfo();

        //存入数据库

        $imgModel = new ServicePattersImg();
        $imgModel->pid = $this->pid;
        $imgModel->pic_path = Yii::getAlias('@web').'/uploads/pattersImg/'.$info['name'];
        $imgModel->save();

    }
}
