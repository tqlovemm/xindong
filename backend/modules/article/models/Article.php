<?php

namespace backend\modules\article\models;

use Yii;
use backend\modules\article\models\ArticleType;

class Article extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'pre_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'title', 'wimg', 'content', 'wtype', 'wclick', 'wdianzan', 'hot'], 'required'],
            [['created_id', 'wtype', 'wclick', 'wdianzan', 'hot', 'created_at', 'updated_at', 'status'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['wimg'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_id' => '发布人ID',
            'title' => '标题',
            'wimg' => '描述图片',
            'content' => '内容',
            'wtype' => 'wtype',
            'wclick' => 'Wclick',
            'wdianzan' => 'Wdianzan',
            'hot' => 'Hot',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_id = Yii::$app->user->id;
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
