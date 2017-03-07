<?php

namespace backend\modules\good\models;

use backend\components\MyUpload;
use frontend\modules\test\models\WeichatDazzleImg;
use Yii;
use yii\myhelper\WaterMark;

/**
 * This is the model class for table "pre_weichat_dazzle".
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
 *
 * @property WeichatDazzleGood[] $weichatDazzleGoods
 * @property WeichatDazzleImg[] $weichatDazzleImgs
 */
class WeichatDazzle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_weichat_dazzle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'num', 'status', 'created_at', 'updated_at'], 'integer'],
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
            'sex' => 'Sex',
            'enounce' => 'Enounce',
            'openId' => 'Open ID',
            'plateId' => 'Plate ID',
            'num' => 'Num',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeichatDazzleGoods()
    {
        return $this->hasMany(WeichatDazzleGood::className(), ['da_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImgs()
    {
        return $this->hasMany(WeichatDazzleImg::className(), ['da_id' => 'id']);
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {

                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }

    }

    public function upload(){

        $config = [
            'savePath'  =>  Yii::getAlias('@webroot/uploads/good'),
            'maxSize'   =>  5000,
            'allowFiles'    =>  ['.jpg','.png','.jpeg','.bmp'],
        ];

        //上传图片,添加水印,压缩图片
        $up = new MyUpload("file",$config,"",true);
        $info = $up->getFileInfo();

        $path = Yii::getAlias('@backend/web/uploads/good/');
        $thumb = $path.'thumb/'.$info['name'];

        //添加水印;
        $mark = new WaterMark();
        $mark->imgMark($path.$info['name'],$path.$info['name'],'http://13loveme.com/images/watermark/3333.png');
        $mark->imgMark($thumb,$thumb,'http://13loveme.com/images/watermark/3333.png');

        $img = new WeichatDazzleImg();
        $img->da_id = $this->id;
        $img->path  = "http://13loveme.com:82/uploads/good/".$info['name'];
        $img->thumb = "http://13loveme.com:82/uploads/good/thumb/".$info['name'];
        $img->status = 0;
        $img->created_at = time();
        $img->updated_at = time();
        $img->save();
    }
}
