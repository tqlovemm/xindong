<?php

namespace backend\modules\seek\models;

use Yii;

/**
 * This is the model class for table "pre_service_patters_add_answers".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $content
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $thumbs_up
 */
class ServicePattersAddAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_service_patters_add_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'content'], 'required'],
            [['pid', 'created_by', 'created_at', 'thumbs_up'], 'integer'],
            [['content'], 'string']
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->created_by = Yii::$app->user->id;
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'content' => 'Content',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'thumbs_up' => 'Thumbs Up',
        ];
    }
}
