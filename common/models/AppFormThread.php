<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pre_app_form_thread".
 *
 * @property integer $wid
 * @property integer $user_id
 * @property string $content
 * @property string $tag
 * @property integer $sex
 * @property string $lat_long
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $is_top
 * @property integer $type
 * @property integer $read_count
 * @property integer $thumbs_count
 * @property integer $comments_count
 * @property integer $admin_count
 * @property integer $total_score
 * @property integer $status
 *
 * @property User $user
 * @property AppFormThreadComments[] $appFormThreadComments
 * @property AppFormThreadImages[] $appFormThreadImages
 * @property AppFormThreadThumbsUp[] $appFormThreadThumbsUps
 */
class AppFormThread extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_form_thread';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'sex', 'updated_at', 'created_at', 'is_top', 'type', 'read_count', 'thumbs_count', 'comments_count', 'admin_count', 'total_score', 'status'], 'integer'],
            [['content'], 'string'],
            [['tag', 'lat_long'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wid' => 'Wid',
            'user_id' => 'User ID',
            'content' => 'Content',
            'tag' => 'Tag',
            'sex' => 'Sex',
            'lat_long' => 'Lat Long',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'is_top' => 'Is Top',
            'type' => 'Type',
            'read_count' => 'Read Count',
            'thumbs_count' => 'Thumbs Count',
            'comments_count' => 'Comments Count',
            'admin_count' => 'Admin Count',
            'total_score' => 'Total Score',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppFormThreadComments()
    {
        return $this->hasMany(AppFormThreadComments::className(), ['thread_id' => 'wid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppFormThreadImages()
    {
        return $this->hasMany(AppFormThreadImages::className(), ['thread_id' => 'wid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppFormThreadThumbsUps()
    {
        return $this->hasMany(AppFormThreadThumbsUp::className(), ['thread_id' => 'wid']);
    }
}
