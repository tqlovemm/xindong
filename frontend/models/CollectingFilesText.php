<?php

namespace frontend\models;

use app\components\Uploader;
use common\components\UploadThumb;
use common\Qiniu\QiniuUploader;
use Yii;

/**
 * This is the model class for table "pre_collecting_files_text".
 *
 * @property integer $id
 * @property string $weichat
 * @property string $cellphone
 * @property string $weibo
 * @property string $email
 * @property string $address
 * @property integer $age
 * @property integer $vip
 * @property integer $sex
 * @property integer $height
 * @property integer $weight
 * @property integer $marry
 * @property string $job
 * @property string $qq
 * @property string $annual_salary
 * @property string $hobby
 * @property string $like_type
 * @property string $car_type
 * @property string $often_go
 * @property string $extra
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $flag
 * @property integer $flop_id
 * @property string $link_flag
 * @property string $weima
 *
 * @property CollectingFilesImg $Imgs
 */
class CollectingFilesText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_collecting_files_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['address'],'required'],
            [[ 'age', 'sex', 'height', 'weight', 'status', 'created_at', 'updated_at','marry','id','flop_id','vip'], 'integer'],
            [['cellphone','weichat', 'weibo','car_type','often_go','qq'], 'string', 'max' => 30],
            [['flag','link_flag','email'], 'string', 'max' => 32],
            [['address','job','annual_salary'], 'string', 'max' => 128],
            [['hobby', 'like_type','weima'], 'string', 'max' => 256],
            [['extra'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'flop_id' => 'Flop id',
            'vip' => '会员等级',
            'link_flag' => 'Link Flag',
            'weichat' => 'Weichat',
            'cellphone' => 'Cellphone',
            'weibo' => 'Weibo',
            'email' => 'Email',
            'address' => 'Address',
            'age' => 'Age',
            'qq' => 'QQ',
            'car_type' => 'Car Type',
            'annual_salary' => 'Annual Salary',
            'often_go' => 'Often Go',
            'sex' => 'Sex',
            'height' => 'Height',
            'weight' => 'Weight',
            'hobby' => 'Hobby',
            'like_type' => 'Like Type',
            'has_car' => 'Has Car',
            'extra' => 'Extra',
            'status' => 'Status',
            'created_at'=> 'Created At',
            'updated_at'=> 'Updated At',
            'flag'=> 'Flag',
            'marry'=> 'Marry',
            'job'=> 'Job',
            'weima'=> 'Weima',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */

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

    public function getImgs()
    {
        return $this->hasMany(CollectingFilesImg::className(), ['text_id' => 'id']);
    }
    public function upload()
    {

        $qn = new QiniuUploader('photoimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->id;
        $qiniu = $qn->upload('tqlmm',"uploads/collecting/$mkdir");

        //存入数据库
        $files_img = new CollectingFilesImg();
        $files_img->img = $qiniu['key'];
        $files_img->thumb_img = $qiniu['key'];
        $files_img->text_id = $this->id;
        $files_img->save();

        $data = array('id'=>$files_img->id,'path'=>Yii::$app->params['imagetqlmm'].$qiniu['key']);
        return $data;
    }
    public function uploadw()
    {

        $qn = new QiniuUploader('weimaimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->id;
        $qiniu = $qn->upload('tqlmm',"uploads/collecting/weima/$mkdir");

        //存入数据库
        $this->weima = $qiniu['key'];
        $this->save();

        $data = array('id'=>$this->id,'path'=>Yii::$app->params['imagetqlmm'].$qiniu['key']);
        return $data;
    }
}
