<?php

namespace backend\modules\sm\models;
use common\Qiniu\QiniuUploader;
use Yii;
/**
 * This is the model class for table "pre_sm_collection_files_text".
 *
 * @property string $member_id
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
 * @property string $extra
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $flag
 * @property integer $status
 * @property string $often_go
 * @property string $annual_salary
 * @property string $weima
 */
class SmCollectionFilesText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_sm_collection_files_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'address', 'flag'], 'required'],
            [[ 'birthday', 'sex', 'height', 'weight', 'marry', 'created_at', 'updated_at', 'status'], 'integer'],
            [['vip','member_id', 'email', 'car_type', 'flag', 'often_go'], 'string', 'max' => 32],
            [['weichat', 'weibo'], 'string', 'max' => 30],
            [['qq'], 'string', 'max' => 11],
            [['cellphone'], 'string', 'max' => 20],
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
            'member_id' => '会员编号',
            'weichat' => '会员微信',
            'qq' => 'Qq',
            'cellphone' => '手机号',
            'weibo' => '微博',
            'email' => '邮箱',
            'vip' => '会员等级',
            'address' => '地区',
            'birthday' => '年龄',
            'sex' => '性别',
            'height' => '身高',
            'weight' => '体重',
            'marry' => '婚姻情况',
            'job' => '工作职业',
            'hobby' => '兴趣爱好',
            'car_type' => '私家车',
            'extra' => '备注',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'status' => '填写情况',
            'often_go' => '常去地',
            'annual_salary' => '年薪',
            'weima' => '微信二维码',
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
        return $this->hasMany(SmCollectionFilesImg::className(), ['member_id' => 'member_id']);
    }

    public function upload()
    {
        $qn = new QiniuUploader('photoimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->member_id;
        $qiniu = $qn->upload('localandsm',"uploads/sm/$mkdir");

        //存入数据库
        $files_img = new SmCollectionFilesImg();
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
        $qiniu = $qn->upload('localandsm',"uploads/sm/$mkdir");

        $model = self::findOne(['member_id'=>$this->member_id]);
        //存入数据库
        $model->weima = $qiniu['key'];
        if($model->update()){
            $data = array('id'=>$this->member_id,'path'=>Yii::$app->params['localandsm'].$qiniu['key']);
            return $data;
        }else{
            return var_dump($this->errors);
        }

    }
}
