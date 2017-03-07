<?php

namespace backend\modules\setting\models;

use Yii;

/**
 * This is the model class for table "pre_app_push".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $is_read
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $message_id
 * @property string $icon
 * @property string $type
 * @property string $cid
 * @property string $title
 * @property string $msg
 * @property string $extras
 * @property string $platform
 * @property string $response
 */
class AppPush extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_push';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','type'], 'required'],
            [['status','is_read','created_at','updated_at'], 'integer'],
            [['cid', 'title','type','icon'], 'string', 'max' => 256],
            [['msg'], 'string', 'max' => 512],
            [['extras'], 'string', 'max' => 1024],
            [['platform', 'response'], 'string', 'max' => 100]
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->updated_at = time();
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
            'status' => 'Status',
            'type' => 'Type',
            'icon' => 'Icon',
            'is_read' => 'Read',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'cid' => 'Cid',
            'title' => 'Title',
            'msg' => 'Msg',
            'extras' => 'Extras',
            'platform' => 'Platform',
            'response' => 'Response',
        ];
    }
}
