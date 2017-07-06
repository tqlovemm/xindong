<?php

namespace backend\modules\authentication\models;

use Yii;

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
class GirlAuthentication extends \yii\db\ActiveRecord
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
            [['user_id', 'video_url', 'created_at', 'updated_at', 'status'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['video_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '女生id',
            'video_url' => '认证视频',
            'created_at' => '上传时间',
            'updated_at' => '修改时间',
            'status' => 'Status',
        ];
    }
}
