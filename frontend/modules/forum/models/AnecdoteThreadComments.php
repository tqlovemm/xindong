<?php

namespace frontend\modules\forum\models;

use Yii;

/**
 * This is the model class for table "pre_anecdote_thread_comments".
 *
 * @property integer $cid
 * @property integer $tid
 * @property string $user_id
 * @property string $comment
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $thumbsup_count
 * @property integer $status
 *
 * @property AnecdoteUsers $user
 * @property AnecdoteThreads $t
 */
class AnecdoteThreadComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_anecdote_thread_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tid', 'user_id', 'comment'], 'required'],
            [['tid', 'thumbsup_count', 'status','created_at', 'updated_at'], 'integer'],
            [['user_id'], 'string', 'max' => 64],
            [['comment'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'tid' => '帖子id',
            'user_id' => '用户id',
            'comment' => '评论内容',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'thumbsup_count' => '点赞数',
            'status' => 'Status',
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AnecdoteUsers::className(), ['user_id' => 'user_id']);
    }

    public function getCos(){

        return $this->hasMany(AnecdoteThreadCommentComments::className(), ['cid' => 'cid']);
    }
    public function getThumbs(){

        /*$user_id = Yii::$app->user->id;
        return $this->hasOne(AnecdoteThreadThumbs::className(), ['tid' => 'cid'])->where(['where'=>2,'pre_anecdote_thread_thumbs.user_id'=>$user_id]);*/
        $user_id = (string)Yii::$app->user->id;
        if(empty($user_id)){
            $user_id = isset($_COOKIE['13_qq_openid'])?$_COOKIE['13_qq_openid']:null;
        }
        if($user_id){
            return $this->hasOne(AnecdoteThreadThumbs::className(), ['tid' => 'cid'])
                ->where(['pre_anecdote_thread_thumbs.user_id'=>$user_id,'pre_anecdote_thread_thumbs.type'=>1,'where'=>2]);
        }else{
            return $this->hasOne(AnecdoteThreadThumbs::className(), ['tid' => 'cid'])->where(['pre_anecdote_thread_thumbs.type'=>6]);
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT()
    {
        return $this->hasOne(AnecdoteThreads::className(), ['tid' => 'tid']);
    }
}
