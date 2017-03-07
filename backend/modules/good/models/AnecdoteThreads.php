<?php

namespace backend\modules\good\models;

use backend\components\MyUpload;
use frontend\modules\forum\models\AnecdoteThreadComments;
use frontend\modules\forum\models\AnecdoteThreadImages;
use frontend\modules\forum\models\AnecdoteThreadThumbs;
use frontend\modules\forum\models\AnecdoteUsers;
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
            [['thumbsup_count','tid', 'thumbsdown_count', 'status','type','created_at', 'updated_at'], 'integer'],
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
            'user_id' => '贴子发布者',
            'content' => '发布的内容',
            'linkurl' => '链接',
            'thumbsup_count' => '点赞数',
            'thumbsdown_count' => '讨厌数',
            'status' => '1：贴子评论，2,：评论的回复',
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
        $config = [
            'savePath' => Yii::getAlias('@frontend/web/uploads/thread_img/'), //存储文件夹
            'maxSize' => 10240 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.png' , '.jpg' , '.jpeg' , '.bmp', '.gif'],  //允许的文件格式
        ];

        $up = new MyUpload('file', $config,$this->tid,true);

        $save_path =  Yii::getAlias('@web/uploads/thread_img/');

        $info = $up->getFileInfo();

        //存入数据库

        $save_img = new AnecdoteThreadImages();
        $save_img->tid = $this->tid;
        $save_img->img = $save_path.$info['name'];
        $save_img->thumbimg = $save_path.'thumb/'.$info['name'];
        $save_img->save();

        /*$data = array('id'=>$save_img->id,'path'=>$save_path.'thumb/'.$info['name']);
        return $data;*/
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
