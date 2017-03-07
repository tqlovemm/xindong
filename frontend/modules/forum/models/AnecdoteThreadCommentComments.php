<?php

namespace frontend\modules\forum\models;

use Yii;

/**
 * This is the model class for table "pre_anecdote_thread_comment_comments".
 *
 * @property integer $ccid
 * @property integer $cid
 * @property string $user_id
 * @property string $to_user_id
 * @property string $content
 * @property integer $created_at
 * @property integer $status
 *
 * @property AnecdoteThreadComments $c
 */
class AnecdoteThreadCommentComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_anecdote_thread_comment_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'user_id','to_user_id', 'content'], 'required'],
            [['cid', 'created_at', 'status'], 'integer'],
            [['user_id','to_user_id'], 'string', 'max' => 64],
            [['content'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ccid' => 'Ccid',
            'cid' => '评论id',
            'user_id' => '回复者id',
            'to_user_id' => '被回复者id',
            'content' => '回复内容',
            'created_at' => 'Created At',
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
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getC()
    {
        return $this->hasOne(AnecdoteThreadComments::className(), ['cid' => 'cid']);
    }
}
