<?php

namespace backend\modules\seek\models;

use Yii;

/**
 * This is the model class for table "pre_service_patters_img".
 *
 * @property integer $pic_id
 * @property integer $pid
 * @property string $pic_path
 * @property integer $created_at
 * @property integer $status
 * @property string $content
 */
class ServicePattersImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_service_patters_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'pic_path'], 'required'],
            [['pid', 'created_at', 'status'], 'integer'],
            [['pic_path', 'content'], 'string', 'max' => 256]
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                if(empty(self::findOne(['pid'=>$this->pid,'status'=>1]))){
                    $this->status = 1;
                }
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
            'pic_id' => 'Pic ID',
            'pid' => 'Pid',
            'pic_path' => 'Pic Path',
            'created_at' => 'Created At',
            'content' => 'Content',
            'status' => 'Status',
        ];
    }
}
