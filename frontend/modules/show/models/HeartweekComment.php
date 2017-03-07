<?php

namespace app\modules\show\models;

use Yii;

/**
 * This is the model class for table "pre_heartweek_comment".
 *
 * @property integer $id
 * @property string $weekly_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property string $content
 * @property integer $status
 * @property integer $likes
 * @property integer $first_comment
 *
 * @property Heartweek $weekly
 */
class HeartweekComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_heartweek_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['weekly_id', 'created_at', 'updated_at', 'user_id', 'status', 'likes', 'first_comment'], 'integer'],
            [['content'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'weekly_id' => 'Weekly ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
            'content' => 'Content',
            'status' => 'Status',
            'likes' => 'Likes',
            'first_comment' => 'First Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeekly()
    {
        return $this->hasOne(Heartweek::className(), ['id' => 'weekly_id']);
    }
}
