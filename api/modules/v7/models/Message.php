<?php

namespace api\modules\v7\models;

use yii;
use app\components\db\ActiveRecord;
use yii\db\Query;

/**
 *  This is the model class for table "pre_app_message".
 * @property integer $id;
 * @property integer $words_id;
 * @property integer $to_id;
 * @property integer $from_id;
 * @property integer $comment_id;
 * @property integer $is_read;
 * @property integer $action;
 * @property integer $created_at;
 * @property integer $updated_at;
 *
 */

class Message extends ActiveRecord
{
    public $avatar;
    public $nickname;
    public $content;
    public $count;
    public $user_id;

    public static function tableName()
    {
        return '{{%app_message}}';
    }

    public function rules()
    {
        return [
            [['id','to_id','words_id','from_id','comment_id','is_read','action','created_at','updated_at'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  'Id',
            'to_id'   =>  'to_id',
            'words_id'   =>  'words_id',
            'from_id'  =>  'from_id',
            'comment_id'  =>  'comment_id',
            'is_read'  =>  'is_read',
            'action'    =>  'action',
            'created_at'    =>  'created_at',
            'updated_at'    =>  'updated_at'
        ];
    }

    public function fields()
    {
        return [
            'mid'   =>  'id',
            'wid'=>'words_id',
            'user_id' => function($model){
                return (int)$model->user_id;
            },
            'comment_id',
            'is_read' ,
            'action',
            'avatar' => function($model){
                $avatar = (new Query())->select('avatar')->from('{{%user}}')->where(['id'=>$model->from_id])->one();
                return $avatar['avatar'];
            },
            'nickname'=>function($model){
                $userInfo = (new Query())->select('nickname,username')->from('{{%user}}')->where(['id'=>$model->from_id])->one();
                if(!$userInfo['nickname']){
                    $userInfo['nickname'] = $userInfo['username'];
                }
                unset($userInfo['username']);
                return $userInfo['nickname'];
            },
            'content' => function($model){
                if($model['comment_id']){
                    $content = (new Query())->select('comment')->from('{{%app_words_comment}}')->where(['id'=>$model->comment_id,])->one();
                    return $content['comment'];
                }
                return null;
            },
            'img' => function($model){

                $content = (new Query())->select('img')->from('{{%app_words}}')->where(['id'=>$model->words_id,])->one();
                if($content){
                    return $content['img'];
                }
                return null;
            },
            'created_at'=>function($model){
                return (string)$model['created_at'];
            },
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }


}