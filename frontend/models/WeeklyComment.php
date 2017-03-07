<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pre_weekly_comment".
 *
 * @property integer $id
 * @property string $weekly_id
 * @property integer $created_at
 * @property integer $user_id
 * @property string $content
 * @property integer $status
 * @property integer $likes
 *
 * @property Weekly $weekly
 */
class WeeklyComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_weekly_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['weekly_id', 'created_at', 'user_id', 'status', 'likes'], 'integer'],
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
            'user_id' => 'User ID',
            'content' => 'Content',
            'status' => 'Status',
            'likes' => 'Likes',
        ];
    }

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
    public function getWeekly()
    {
        return $this->hasOne(Weekly::className(), ['id' => 'weekly_id']);
    }
}
