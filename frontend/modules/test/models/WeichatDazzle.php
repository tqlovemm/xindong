<?php

namespace frontend\modules\test\models;

use common\components\UploadThumb;
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
            [['openId'], 'string', 'max' => 50],
            [['enounce'],'string','max'=>50],
            [['plateId'],'string','max'=>32],
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

    public function Upload(){

        $config = [
            'savePath'   => Yii::getAlias('@webroot/uploads/abd'),
            'maxSize'    => 5000,
            'allowFiles' => ['.jpg','.jpeg','.png','.bmp']
        ];

        $u = new UploadThumb('photoimg',$config,"",true);
        $info = $u->getFileInfo();
        $path = Yii::getAlias('@web/uploads/abd/');
        //添加水印;
        $mark = new WaterMark();
        $mark->ImgMark(Yii::getAlias('@webroot/uploads/abd/').$info['name'],Yii::getAlias('@webroot/uploads/abd/').$info['name'],'http://13loveme.com/images/watermark/3333.png');
        $mark->imgMark(Yii::getAlias('@webroot/uploads/abd/thumb/').$info['name'],Yii::getAlias('@webroot/uploads/abd/thumb/').$info['name'],'http://13loveme.com/images/watermark/3333.png');

        $img = new WeichatDazzleImg();
        $img->da_id         = $this->id;
        $img->created_at    = time();
        $img->updated_at    = time();
        $img->path          = 'http://13loveme.com'.$path.$info['name'];
        $img->thumb         = 'http://13loveme.com'.$path."thumb/".$info['name'];
        $img->save();
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        }else{
            return false;
        }

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
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

    public function getImg()
    {
        return $this->hasOne(WeichatDazzleImg::className(), ['da_id' => 'id']);
    }
}
