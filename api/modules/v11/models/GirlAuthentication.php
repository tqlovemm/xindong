<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_girl_authentication".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $video_url
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class GirlAuthentication extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_girl_authentication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'video_url','status'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['video_url'], 'string', 'max' => 255]
        ];
    }

    public function fields()
    {
        return [
            'user_id', 'video_url','status'
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
            'video_url' => 'Video Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
