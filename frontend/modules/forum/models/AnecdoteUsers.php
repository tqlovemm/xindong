<?php

namespace frontend\modules\forum\models;

use backend\components\MyUpload;
use Yii;

/**
 * This is the model class for table "pre_anecdote_users".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $headimgurl
 * @property string $username
 *
 * @property AnecdoteThreadComments[] $anecdoteThreadComments
 * @property AnecdoteThreads[] $anecdoteThreads
 */
class AnecdoteUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_anecdote_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'username'], 'required'],
            [['user_id', 'username'], 'string', 'max' => 64],
            [['headimgurl'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'headimgurl' => 'Headimgurl',
            'username' => 'Username',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnecdoteThreadComments()
    {
        return $this->hasMany(AnecdoteThreadComments::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnecdoteThreads()
    {
        return $this->hasMany(AnecdoteThreads::className(), ['user_id' => 'user_id']);
    }

    public function upload()
    {
        $config = [
            'savePath' => Yii::getAlias('@frontend/web/uploads/thread_img/'), //存储文件夹
            'maxSize' => 10240 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.png' , '.jpg' , '.jpeg' , '.bmp', '.gif'],  //允许的文件格式
        ];

        $up = new MyUpload("file", $config, $this->id,true);

        $save_path =  Yii::getAlias('@web/uploads/thread_img/');

        $info = $up->getFileInfo();

        //存入数据库

        $model = $this->findOne($this->id);
        $model->headimgurl = 'http://13loveme.com'.$save_path.'thumb/'.$info['name'];
        $model->save();

    }
}
