<?php

namespace backend\modules\good\models;

use common\components\UploadThumb;
use Yii;
use yii\myhelper\WaterMark;

/**
 * This is the model class for table "pre_weichat_vote_img".
 *
 * @property integer $id
 * @property integer $vote_id
 * @property string $path
 * @property string $thumb
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property WeichatVote $vote
 */
class WeichatVoteImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_weichat_vote_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vote_id', 'path', 'thumb', 'status', 'created_at', 'updated_at'], 'required'],
            [['vote_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['path', 'thumb'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vote_id' => 'Vote ID',
            'path' => 'Path',
            'thumb' => 'Thumb',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVote()
    {
        return $this->hasOne(WeichatVote::className(), ['id' => 'vote_id']);
    }
}
