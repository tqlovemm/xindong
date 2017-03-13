<?php

namespace frontend\models;

use app\components\Uploader;
use common\Qiniu\QiniuUploader;
use Yii;

/**
 * This is the model class for table "pre_collecting_17_files_text".
 *
 * @property integer $id
 * @property string $weichat
 * @property string $cellphone
 * @property string $address_province
 * @property string $address_province2
 * @property string $address_province3
 * @property string $address_city
 * @property string $address_city2
 * @property string $address_city3
 * @property string $address_detail
 * @property string $education
 * @property integer $age
 * @property integer $sex
 * @property integer $height
 * @property integer $weight
 * @property string $cup
 * @property string $id_number
 * @property string $weibo
 * @property integer $qq
 * @property string $pay
 * @property string $job
 * @property string $job_detail
 * @property integer $gotofield
 * @property string $time_slot_start
 * @property string $time_slot_end
 * @property string $extra
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $flag
 * @property integer $status
 * @property integer $already_pa
 *
 * @property Collecting17FilesImg[] $collecting17FilesImgs
 */
class CollectingSeventeenFilesText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_collecting_17_files_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','age', 'sex', 'height','weight', 'gotofield', 'created_at', 'updated_at','qq', 'status','already_pa'], 'integer'],
            [['weichat'], 'string', 'max' => 30],
            [['cellphone','id_number'], 'string', 'max' => 20],
            [['address_province','address_city','address_province2','address_city2', 'address_province3', 'pay', 'address_city3', 'job'], 'string', 'max' => 128],
            [['education'], 'string', 'max' => 125],
            [['cup','weibo'], 'string', 'max' => 50],
            [['extra','address_detail', 'job_detail'], 'string', 'max' => 512],
            [['flag'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'weichat' => 'Weichat',
            'cellphone' => 'Cellphone',
            'address_province' => 'Address Province',
            'address_city' => 'Address City',
            'address_city2' => 'Address City',
            'address_city3' => 'Address City',
            'address_detail' => 'Address Detail',
            'address_detail2' => 'Address Detail',
            'address_detail3' => 'Address Detail',
            'education' => 'Education',
            'age' => 'Age',
            'sex' => 'Sex',
            'height' => 'Height',
            'weight' => 'Weight',
            'cup' => 'Cup',
            'job' => 'Job',
            'job_detail' => 'Job Detail',
            'gotofield' => 'Gotofield',
            'opposite_id_card' => 'Opposite Id Card',
            'positive_id_card' => 'Positive Id Card',
            'extra' => 'Extra',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'status' => 'Status',
            'already_pa' => 'Already Pa',
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImgs()
    {
        return $this->hasMany(CollectingSeventeenFilesImg::className(), ['text_id' => 'id'])->where(['type'=>0]);
    }

    public function upload()
    {
        $qn = new QiniuUploader('photoimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $qiniu = $qn->upload('shisan',"uploads/collecting-17/$this->id");
 /*       $config = [
            'savePath' => Yii::getAlias('@webroot/uploads/collecting-17/'), //存储文件夹
            'maxSize' => 10240 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];*/
        Yii::$app->db->createCommand()->insert('{{%collecting_17_files_img}}', [
            'img' => $qiniu['key'], //存储路径
            'text_id' => $this->id, //保存的名称
        ])->execute();
        $data = array('id'=>$this->id,'path'=>Yii::$app->params['shisan'].$qiniu['key']);
        return $data;

      /*  $up = new Uploader("photoimg", $config, 'collecting_17_files');

        $save_path =  Yii::getAlias('@web/uploads/collecting-17/');

        $info = $up->getFileInfo();

        //存入数据库
        Yii::$app->db->createCommand()->insert('{{%collecting_17_files_img}}', [
            'img' => $qiniu['key'], //存储路径
            'text_id' => $this->id, //保存的名称
        ])->execute();
        $data = array('id'=>$this->id,'path'=>$save_path.$info['name']);
        return $data;*/
    }

    public function uploadw()
    {
        $qn = new QiniuUploader('weimaimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $qiniu = $qn->upload('shisan',"uploads/collecting-17/weima/$this->id");

        Yii::$app->db->createCommand()->insert('{{%collecting_17_files_img}}', [
            'img' =>$qiniu['key'], //存储路径
            'text_id' => $this->id, //保存的名称
            'type' => 1, //保存的名称
        ])->execute();
        $data = array('id'=>$this->id,'path'=>Yii::$app->params['shisan'].$qiniu['key']);
        return $data;
        /*$config = [
            'savePath' => Yii::getAlias('@webroot/uploads/collecting-17/'), //存储文件夹
            'maxSize' => 10240 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];

        $up = new Uploader("weimaimg", $config, 'collecting_17_files');

        $save_path =  Yii::getAlias('@web/uploads/collecting-17/');

        $info = $up->getFileInfo();

        //存入数据库
        Yii::$app->db->createCommand()->insert('{{%collecting_17_files_img}}', [
            'img' => $save_path.$info['name'], //存储路径
            'text_id' => $this->id, //保存的名称
            'type' => 1, //保存的名称
        ])->execute();
        $data = array('id'=>$this->id,'path'=>$save_path.$info['name']);
        return $data;*/
    }
}
