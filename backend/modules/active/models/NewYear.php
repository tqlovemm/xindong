<?php

namespace backend\modules\active\models;

use backend\components\MyUpload;
use common\components\UploadThumb;
use Yii;
use yii\myhelper\WaterMark;

/**
 * This is the model class for table "pre_new_year".
 *
 * @property integer $id
 * @property integer $sex
 * @property string $enounce
 * @property string $openId
 * @property string $plateId
 * @property integer $num
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class NewYear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_new_year';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'num', 'status', 'created_at', 'updated_at'], 'integer'],
            [['openId'], 'required'],
            [['enounce', 'openId', 'plateId'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sex' => '性别',
            'enounce' => '宣言',
            'openId' => 'Open ID',
            'plateId' => '平台号',
            'num' => '点赞数',
            'status' => '发布状态（1审核中，2审核通过，3审核不通过）',
            //'created_at' => 'Created At',
            //'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }


    public function upload(){

        $config = [
            'savePath'   => Yii::getAlias('@frontend/web/uploads/newy'),
            'maxSize'    => 5000,
            'allowFiles' => ['.jpg','.jpeg','.png','.bmp']
        ];

        $up = new MyUpload("file",$config,"",true);

        $info = $up->getFileInfo();
        //添加水印;
        $mark = new WaterMark();
        $mark->ImgMark($config['savePath'].'/'.$info['name'],$config['savePath'].'/'.$info['name'],'http://13loveme.com/images/watermark/3333.png');
        $mark->imgMark($config['savePath'].'/thumb/'.$info['name'],$config['savePath'].'/thumb/'.$info['name'],'http://13loveme.com/images/watermark/3333.png');

        $img = new NewYearImg();
        $img->da_id         = $this->id;
        $img->created_at    = time();
        $img->updated_at    = time();
        $img->path          = 'http://13loveme.com/uploads/newy/'.$info['name'];
        $img->thumb         = 'http://13loveme.com/uploads/newy/thumb/'.$info['name'];
        $img->save();
    }
}
