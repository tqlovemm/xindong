<?php

namespace frontend\modules\article\models;

use Yii;

/**
 * This is the model class for table "pre_article_comment".
 *
 * @property integer $id
 * @property integer $aid
 * @property integer $cid
 * @property string $content
 * @property integer $created_id
 * @property integer $reply_to
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class ArticleComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_article_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'content'], 'required'],
            [['aid', 'cid', 'created_id', 'reply_to', 'created_at', 'updated_at', 'status'], 'integer'],
            [['content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid' => 'Aid',
            'cid' => 'Cid',
            'content' => 'Content',
            'created_id' => 'Created ID',
            'reply_to' => 'Reply To',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->status = 1;
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
}
