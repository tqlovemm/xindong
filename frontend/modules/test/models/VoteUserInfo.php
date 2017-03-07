<?php
namespace frontend\modules\test\models;

use common\components\UploadThumb;
use yii;
use yii\db\ActiveRecord;
use yii\myhelper\WaterMark;

/**
 * This is the model class for table "{{%weichat_vote}}".
 *
 * @property integer $id
 * @property integer $sex
 * @property string $enounce
 * @property integer $created_at
 * @property string $openId
 * @property string $plateId
 * @property integer $status
 * @property integer $num
 * @property integer $updated_at
 */
class VoteUserInfo extends ActiveRecord
{

    public static function tableName(){
        return "{{%weichat_vote}}";
    }

    public function rules()
    {
        return [

            [['sex','status','num','created_at','updated_at'],'integer'],
            [['enounce'],'string','max'=>50],
            [['plateId'],'string','max'=>32],
            [['openId'],'string','max'=>64],
        ];
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

    public function attributeLabels()
    {
        return [
            'sex'   =>  '性别',
            'enounce'   =>  '交友宣言',
            'plateId'   =>  '微博号',
            'num'   =>  '点赞数',
            'openId'    =>  'openId',

        ];
    }

    public function getImgs(){

        return $this->hasMany(VoteUserImg::className(),['vote_id'=>"id"]);
    }

    public function getImg(){

        return $this->hasOne(VoteUserImg::className(),['vote_id'=>"id"]);
    }

    public function getGoods(){

        return $this->hasMany(VoteUserGood::className(),['vote_id'=>"id"]);
    }

    public function upload(){

        $config = [
            'savePath'  =>  Yii::getAlias('@webroot/uploads/vote_2'),
            'maxSize'   =>  5000,
            'allowFiles'    =>  ['.jpg','.png','.jpeg','.bmp'],
        ];

        //上传图片,添加水印,压缩图片
        $up = new UploadThumb("photoimg",$config,$this->id,true);
        $info = $up->getFileInfo();
        $path = Yii::getAlias('@web/uploads/vote_2/');


        //添加水印;
        $mark = new WaterMark();
        $mark->imgMark(Yii::getAlias('@webroot/uploads/vote_2/').$info['name'],Yii::getAlias('@webroot/uploads/vote_2/').$info['name'],'http://13loveme.com/images/watermark/3333.png');
        $mark->imgMark(Yii::getAlias('@webroot/uploads/vote_2/thumb/').$info['name'],Yii::getAlias('@webroot/uploads/vote_2/thumb/').$info['name'],'http://13loveme.com/images/watermark/3333.png');

        $img = new VoteUserImg();
        $img->vote_id = $this->id;
        $img->created_at = time();
        $img->updated_at = time();
        $img->path = 'http://13loveme.com'.$path.$info['name'];
        $img->thumb = 'http://13loveme.com'.$path.'/thumb/'.$info['name'];
        $img->save();

        $data = array("id"=>$this->id,"path"=>$img->thumb);
        return $data;

    }
}