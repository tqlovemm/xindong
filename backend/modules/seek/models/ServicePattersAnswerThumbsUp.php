<?php

namespace backend\modules\seek\models;

use Yii;

/**
 * This is the model class for table "pre_service_patters_answer_thumbs_up".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $created_by
 * @property integer $type
 */
class ServicePattersAnswerThumbsUp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_service_patters_answer_thumbs_up';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid'], 'required'],
            [['pid', 'created_by', 'type'], 'integer']
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
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
            'created_by' => 'Created By',
            'type' => 'Type',
        ];
    }
}
