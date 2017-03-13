<?php

namespace frontend\modules\forum\models;

use common\components\UploadThumb;
use common\Qiniu\QiniuUploader;
use frontend\components\UploadThumbAndWatermark;
use Yii;

/**
 * This is the model class for table "pre_anecdote_threads".
 *
 * @property integer $tid
 * @property string $user_id
 * @property string $content
 * @property string $linkurl
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $thumbsup_count
 * @property integer $thumbsdown_count
 * @property integer $type
 * @property integer $status
 *
 * @property AnecdoteThreadComments[] $anecdoteThreadComments
 * @property AnecdoteUsers $user
 */
class AnecdoteThreads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_anecdote_threads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['thumbsup_count', 'thumbsdown_count', 'status','type','created_at', 'updated_at'], 'integer'],
            [['user_id'], 'string', 'max' => 64],
            [['content','linkurl'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tid' => 'Tid',
            'user_id' => 'User ID',
            'content' => 'Content',
            'linkurl' => 'Linkurl',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'thumbsup_count' => 'Thumbsup Count',
            'thumbsdown_count' => 'Thumbsdown Count',
            'status' => 'Status',
            'type' => 'Type',
        ];
    }
    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {

                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }

    public function upload()
    {
        $qn = new QiniuUploader('threadimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $qiniu = $qn->upload('threadimages',"uploads/thread_img/$this->tid");
/*        $config = [
            'savePath' => Yii::getAlias('@webroot/uploads/thread_img/'), //存储文件夹
            'maxSize' => 10240 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.png' , '.jpg' , '.jpeg' , '.bmp', '.gif'],  //允许的文件格式
        ];

        $up = new UploadThumbAndWatermark("threadimg", $config, $this->tid,true);

        $save_path =  Yii::getAlias('@web/uploads/thread_img/');

        $info = $up->getFileInfo();*/

        //存入数据库

        $save_img = new AnecdoteThreadImages();
        $save_img->tid = $this->tid;
        $save_img->img = $qiniu['key'];
        $save_img->thumbimg = $qiniu['key'];
        $save_img->save();

        $data = array('id'=>$save_img->id,'path'=>Yii::$app->params['threadimg'].$qiniu['key']);
        return $data;
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getComments()
    {
        return $this->hasMany(AnecdoteThreadComments::className(), ['tid' => 'tid']);
    }

    public function getCount(){

        return AnecdoteThreadComments::find()->where(['tid'=>$this->tid]);
    }
    public function getThumbs(){

        $user_id = (string)Yii::$app->user->id;
        if(empty($user_id)){
            $user_id = isset($_COOKIE['13_qq_openid'])?$_COOKIE['13_qq_openid']:null;
        }
        if($user_id){
            return $this->hasOne(AnecdoteThreadThumbs::className(), ['tid' => 'tid'])->where(['pre_anecdote_thread_thumbs.user_id'=>$user_id,'where'=>1]);
        }else{
            return $this->hasOne(AnecdoteThreadThumbs::className(), ['tid' => 'tid'])->where(['pre_anecdote_thread_thumbs.type'=>6]);
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */

    public function getImg()
    {
        return $this->hasMany(AnecdoteThreadImages::className(), ['tid' => 'tid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AnecdoteUsers::className(), ['user_id' => 'user_id']);
    }
}
