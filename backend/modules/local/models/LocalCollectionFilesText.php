<?php

namespace backend\modules\local\models;

use backend\components\UploadThumb;
use common\Qiniu\QiniuUploader;
use Yii;

/**
 * This is the model class for table "pre_local_collection_files_text".
 *
 * @property string $member_id
 * @property string $local
 * @property string $weichat
 * @property string $qq
 * @property string $cellphone
 * @property string $weibo
 * @property string $email
 * @property string $vip
 * @property string $address
 * @property integer $birthday
 * @property integer $sex
 * @property integer $height
 * @property integer $weight
 * @property integer $marry
 * @property string $job
 * @property string $hobby
 * @property string $car_type
 * @property string $like_type
 * @property string $extra
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $flag
 * @property integer $status
 * @property string $often_go
 * @property string $annual_salary
 * @property string $weima
 */
class LocalCollectionFilesText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_local_collection_files_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'address', 'flag','local'], 'required'],
            [['birthday', 'sex', 'height', 'weight', 'marry', 'created_at', 'updated_at', 'status'], 'integer'],
            [['member_id', 'email', 'car_type', 'flag', 'often_go','like_type','local','weichat', 'weibo'], 'string', 'max' => 32],
            [['vip','qq'], 'string', 'max' => 11],
            [['cellphone'], 'string', 'max' => 16],
            [['address', 'job', 'annual_salary'], 'string', 'max' => 128],
            [['hobby', 'weima'], 'string', 'max' => 256],
            [['extra'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'Member ID',
            'local' => 'Local',
            'weichat' => 'Weichat',
            'qq' => 'Qq',
            'cellphone' => 'Cellphone',
            'weibo' => 'Weibo',
            'email' => 'Email',
            'vip' => 'Vip',
            'address' => 'Address',
            'birthday' => 'Birthday',
            'sex' => 'Sex',
            'height' => 'Height',
            'weight' => 'Weight',
            'marry' => 'Marry',
            'job' => 'Job',
            'hobby' => 'Hobby',
            'car_type' => 'Car Type',
            'like_type' => 'Like Type',
            'extra' => 'Extra',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'status' => 'Status',
            'often_go' => 'Often Go',
            'annual_salary' => 'Annual Salary',
            'weima' => 'Weima',
        ];
    }

    public function beforeSave($insert){

        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }else{
            return false;
        }
    }

    public function getImg()
    {
        return $this->hasMany(LocalCollectionFilesImg::className(), ['member_id' => 'member_id']);
    }

    public function upload()
    {
        $qn = new QiniuUploader('photoimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->member_id;
        $qiniu = $qn->upload('localandsm',"uploads/local/$mkdir");
       /* $config = [
            'savePath' => Yii::getAlias('@webroot/uploads/local/'), //存储文件夹
            'maxSize' => 10240 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];

        $up = new UploadThumb("photoimg", $config,$this->member_id,true);
        $save_path =  Yii::getAlias('@web/uploads/local/');

        $info = $up->getFileInfo();*/

        //存入数据库
        $files_img = new LocalCollectionFilesImg();
        $files_img->img_path = $qiniu['key'];
        $files_img->thumb_img_path = $qiniu['key'];
        $files_img->member_id = $this->member_id;
        $files_img->save();

        $data = array('id'=>$files_img->img_id,'path'=>Yii::$app->params['localandsm'].$qiniu['key']);
        return $data;
    }
    public function uploadw()
    {
        $qn = new QiniuUploader('weimaimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->member_id;
        $qiniu = $qn->upload('localandsm',"uploads/local/$mkdir");
  /*      $config = [
            'savePath' => Yii::getAlias('@webroot/uploads/local/weima/'), //存储文件夹
            'maxSize' => 10240 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];

        $up = new UploadThumb("weimaimg", $config,$this->member_id,false);
        $save_path =  Yii::getAlias('@web/uploads/local/weima/');

        $info = $up->getFileInfo();*/

        //存入数据库
        $this->weima = $qiniu['key'];
        $this->save();
        $data = array('id'=>$this->member_id,'path'=>Yii::$app->params['localandsm'].$qiniu['key']);
        return $data;
    }
}
