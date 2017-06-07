<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

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
class ArticlePl extends ActiveRecord
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
            [['aid', 'content', 'created_id','status'], 'required'],
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
}
